<?php
include('./session.php');
include("../connexion.php");

//On redirect sur login si le client n'est pas connecté ou si c'est un admin
$url = $_SERVER['HTTP_REFERER'];
$tableau = explode("/", $url, -1);
$location = "";
foreach ($tableau as $valeur) {
    $location = $location . $valeur . "/";
}
$location = $location . 'login.php';
if (!isset($_SESSION['type'])) {
    header( "refresh:5;url=$location" );
    include("./en-tete.php");
    include("./menu.php");
    echo "<br><br>Vous devez être connecté pour réserver, vous serez redirigé vers la page de connexion dans 5 secondes<br><br>";
    echo "<a href=\"".$location."\">Cliquez ici si la redirection automatique ne marche pas.</a>";
    die;
}elseif($_SESSION['type']=='admin'){
    include("./en-tete.php");
    include("./menu.php");
    echo "Un admin ne peut pas reserver : <a href=\"./chalet.php\">Retour</a>";
    die;
}
include("./en-tete.php");
include("./menu.php");
if(!isset($_GET['c'])){
    $_GET['c']="def";
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="Expires" content="0">
    <title>Reservation</title>
    <link rel="stylesheet" href="styles.css" />
</head>

<body>
    <?php
        switch ($_GET['c']) {

            case 'check':
                //On converti la date au samedi d'avant
                $date = new DateTime ($_GET['date']);
                $jour = $date -> format ('D');
                if($jour=="Mon"){
                    $date->sub(new DateInterval('P2D'));
                    echo "Les réservation se font du samedi au samedi, nous avons donc selectionné le samedi d'avant.";
                }elseif($jour=="Tue"){
                    $date->sub(new DateInterval('P3D'));
                    echo "Les réservation se font du samedi au samedi, nous avons donc selectionné le samedi d'avant.";
                }elseif($jour=="Wed"){
                    $date->sub(new DateInterval('P4D'));
                    echo "Les réservation se font du samedi au samedi, nous avons donc selectionné le samedi d'avant.";
                }elseif($jour=="Thu"){
                    $date->sub(new DateInterval('P5D'));
                    echo "Les réservation se font du samedi au samedi, nous avons donc selectionné le samedi d'avant.";
                }elseif($jour=="Fri"){
                    $date->sub(new DateInterval('P6D'));
                    echo "Les réservation se font du samedi au samedi, nous avons donc selectionné le samedi d'avant.";
                }elseif($jour=="Sun"){
                    $date->sub(new DateInterval('P1D'));
                    echo "Les réservation se font du samedi au samedi, nous avons donc selectionné le samedi d'avant.";
                }

                //On check si la semaine est dans la base
                $sql = "SELECT * FROM semaine";
                $resultat = mysqli_query($conn, $sql);
                if ($resultat == FALSE) {
                    die("<br>Echec d'execution de la requete : " . $sql);
                }
                //on crée un tableau des dates dans la base
                while ($row = mysqli_fetch_assoc($resultat)) {
                    $array[]=$row['date_debut'];
                }
                //On crée un tableau string des dates dans le format américain : $array_date_str et fr : $array_date_str_clean
                for($i=0; $i< $_GET['nbr_semaine']; $i++){
                    $strdate = $date->format('Y-m-d');
                    $array_date_str[] = $strdate;
                    $strdate_clean = $date->format('d-m-Y');
                    $array_date_str_clean[] = $strdate_clean;
                    $date->add(new DateInterval('P7D'));
                }
                //On vérifie que chaque semaine soit dans le tableau, si non, nous arretons le processus
                $i = 0;
                foreach($array_date_str as $date_resa){
                    if (!in_array($date_resa, $array)){
                        echo "La semaine du ". $array_date_str_clean[$i] ." n'est pas une semaine ou nous recevons des vacanciers, nous vous invitons à en choisir une autre ! <br>";
                        echo "<a href=./reserver.php?cat=1>Retour</a>";
                        die;
                    }
                    $i = $i + 1 ;
                }
                

                //On vérifie qu'un chalet est dispo a ces dates

                // On regarde combien de chalet de la catégorie il y a en tout
                $sql = 'select count(id_type_chalet) as nbr_chalet_total from chalet where id_type_chalet =' . $_GET['cat'];
                $resultat = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($resultat);
                $nbr_chalet_total = $row['nbr_chalet_total'];

                // On regarde combien sont réservés pour les dates, on soustrait, si <1, on annule
                $i = 0 ;
                foreach($array_date_str as $datedate){
                    $sql="Select count(reservation.id_chalet) as nbr_chalet_resa from reservation inner join semaine on reservation.id_semaine = semaine.id_semaine inner join chalet on reservation.id_chalet = chalet.id_chalet where id_type_chalet =". $_GET['cat'] . " and date_debut = '". $datedate ."'";
                    $resultat = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($resultat);
                    $nbr_chalet_resa = $row['nbr_chalet_resa'];
                    $nbr_chalet_restant = $nbr_chalet_total - $nbr_chalet_resa ;
                    if ($nbr_chalet_restant < 1){
                        echo "<br><br>Nous sommes désolés, nous n'avons plus de chalet de cette catégorie disponible pour la semaine du : " . $array_date_str_clean[$i];
                        echo "<br> Nous vous invitons à changer votre réservation "; 
                        echo "<br><a href=./reserver.php?cat=1>Retour</a>";
                        die;
                    }
                    $i = $i + 1 ;
                }
                //On vérifie prix spé
                // sql :
                //Select *
                //from prix_special inner join semaine on prix_special.id_semaine = semaine.id_semaine inner join chalet on prix_special.id_chalet = chalet.id_chalet
                //where id_type_chalet = 1 and date_debut = '2021.04.10'
                
                //On recapitule la résa prix, les semaines et le chalet
                echo "<br><br> La réservation commencera le : " . $array_date_str_clean[0] . " pour une durée de ". $_GET['nbr_semaine']." semaines<br><br>";
                
                //On enregistre la résa
                // Trouver un chalet dispo, du type voulu sur toutes les semaines, de pref le même
                //elle va etre rigolote a faire cette requete

                //C EST DE LA MERDEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEE
                       
                break;
            
            default :
                ?>
                <!-- Formulaire pour demander la réservation -->
                <form action="./reserver.php" method="get">
                    <label for="date">Entrez la date du premier samedi de votre reservation :</label>
                    <input type="date" id="date" name="date" required><br><br>
                    <label for="nbr_semaine">Combien de semaines ?:</label>
                    <input type="number" id="nbr_semaine" name="nbr_semaine" min=1 required><br><br>
                    <label for="cat">Le type de chalet :</label>
                    <select name="cat" id="cat">
                            <option value="1" <?php if($_GET['cat']==1){echo "selected";} ?> >Mini</option>
                            <option value="2" <?php if($_GET['cat']==2){echo "selected";} ?> >Grand</option>
                            <option value="3" <?php if($_GET['cat']==3){echo "selected";} ?> >Grand luxe</option>
                        </select><br><br>
                    <input type="hidden" name="c" value="check">        
                    <input type="submit" value="Obtenez les tarifs">
                </form>
                <?php
                break;
        }
    ?>
</body>
<?php
    include("./footer.html")
    ?>
</html>
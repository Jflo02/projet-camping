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
                $strdate = $date->format('d-m-Y');
                echo "<br><br> La réservation commencera le : " . $strdate . "<br><br>";

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
                $date_string = $date-> format ('Y-m-d');
                //On vérifie si la semaine est dans le tableau, si non, nous arretons le processus
                if (!in_array($date_string, $array)){
                    echo "Cette semaine n'est pas une semaine ou nous recevons des vacanciers, nous vous invitons à en choisir une autre ! <br>";
                    echo "<a href=./reserver.php?cat=1>Retour</a>";
                    die;
                }
                //On vérifie le nombre de semaine
                //On vérifie la dispo
                //On vérifie prix spé
                //On confirme le prix, les semaines et le chalet
                //On enregistre la résa
                
                    

                       
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
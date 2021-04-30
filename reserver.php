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

            case 'resa':
                foreach(range(0, $_GET['nbr_semaine'] - 1) as $value){
                    $prix = "prix".$value;
                    $semaine = "semaine".$value;
                    $sql="Select * From semaine WHERE date_debut = '". $_GET[$semaine] ."'";
                    $resultat = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($resultat);
                    $id_semaine = $row['id_semaine'];
                    $chalet = "chalet".$value;
                    $today = date('Y-m-d');
                    $sql = "INSERT INTO reservation
                            VALUES (". $_SESSION['id_user'] .",". $_GET[$chalet] .",". $id_semaine .",TRUE,'". $today ."',". $_GET[$prix] .")";
                    $resultat = mysqli_query($conn, $sql);
                }
                if ($resultat == FALSE) {
                    die("<br>Echec d'execution de la requete : " . $sql);
                }else{
                   echo "Votre validation a été prise en charge, un email vous a été envoyé.";
                   $to = $_SESSION['mail'];
                   echo "<br><br><div class=\"jumbotron\"> A l'attention de Mr DELCAMBRE, nous avons une erreur car le serveur mail n'est pas configuré. <br></div>";
                   mail ( $to , "réservation camping du plaisir" , "Bonjour, \n vous avez réservé, des bisous see you soon au camping" );
                   echo "<br><a href=./index.php>Retour a l'accueil</a>";
                   echo "<br><a href=./reservations.php>Voir vos reservations</a>";
                }
                break;

            case 'check':

                ?>
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col align-self-center">
                            <table class="table table-striped">
                <?php
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
                //On recapitule la date de la résa et le nombre de semaine
                echo "<br> La réservation commencera le : " . $array_date_str_clean[0] . " pour une durée de ". $_GET['nbr_semaine']." semaines.<br><br>";
                //On vérifie prix spé           
                Foreach($array_date_str as $date_str){
                    $sql="Select *
                    from prix_special inner join semaine on prix_special.id_semaine = semaine.id_semaine inner join chalet on prix_special.id_chalet = chalet.id_chalet
                    where id_type_chalet =". $_GET['cat'] ." and date_debut = '". $date_str ."' and (semaine.id_semaine, chalet.id_chalet) not in (select id_semaine, id_chalet from reservation)";
                    $result = mysqli_query($conn, $sql);
                    //on créer un tableau pour savoir les semaines en promos
                    if (mysqli_num_rows($result)==0) {
                        $promo[]=FALSE;
                    }else{
                        $promo[]=TRUE;
                    }
                }
                $i=0;
                //on affiche le prix semaine par semaine et on le rentre dans un tableau :
                Foreach($promo as $value){
                    if($value){
                        $sql="Select *
                            from prix_special inner join semaine on prix_special.id_semaine = semaine.id_semaine inner join chalet on prix_special.id_chalet = chalet.id_chalet
                            where id_type_chalet =". $_GET['cat'] ." and date_debut = '". $array_date_str[$i] ."'";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        $prix_semaine[]=$row['prix_modifie'];
                        $saison_semaine[]='PROMO';
                    }else{
                        //on recupère le multiplicateur de saison
                        $sql = "Select *
                                From semaine inner join saison on semaine.id_saison=saison.id_saison
                                where date_debut = '". $array_date_str[$i] ."'";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        $saison = $row['type'];
                        $taux = $row['taux'];
                        //on récupère le prix de base du chalet
                        $sql = "SELECT * FROM type_chalet where id_type_chalet =" . $_GET['cat'];
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        $prix_base = $row['prix_base'];
                        $prix_final = $prix_base * $taux ;
                        $prix_semaine[]=$prix_final;
                        $saison_semaine[]=$saison;
                    }
                    $i++;
                }
                //On calcul le prix total de la résa
                $prix_total = 0 ;
                foreach($prix_semaine as $value){
                    $prix_total=$prix_total+$value;
                }

                //On trouve les ID chalet libre correspondant à la demande
                foreach($array_date_str as $datesemaine){
                    $sql = "Select *
                    From chalet
                    where id_type_chalet=". $_GET['cat'] ." and id_chalet not in (Select id_chalet 
                                                                From reservation inner join semaine on reservation.id_semaine = semaine.id_semaine 
                                                                where date_debut='". $datesemaine ."')";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        //on récupère les chalets dispos dans un tableau
                        $dispo_semaine[]=$row['id_chalet'];
                    }
                    //On récupère la liste des ID chalet dispo par semaine dans un tableau de tableau
                    $chalet[]=$dispo_semaine;
                    unset($dispo_semaine);                    
                }
                //On essaye de trouver un chalet dispo pour toute la résa
                $liste_chalet_possible=$chalet[0];
                foreach ($chalet as $listedipo) {
                    $liste_chalet_possible = array_intersect($liste_chalet_possible, $listedipo);
                }
                $firstkey = array_key_first($liste_chalet_possible);
                //Si aucun chalet n'est dispo sur la semaine, nous placons le client dans le premier chalet de chaque semaine
                //Si un chalet ou plusieurs chalet sont dispo, nous plaçons le client dans le premier de la liste
                if (count($liste_chalet_possible)==0){
                    echo "Nous sommes désolé, aucun chalet n'est disponible pour l'entiereté de votre sejour, vous avez été placé dans différents chalets</br>";
                    foreach($chalet as $chaletsemaine){
                        $chalet_choisi[]=$chaletsemaine[0];
                    }
                }else{
                    foreach($chalet as $chaletsemaine){
                        $chalet_choisi[]=$liste_chalet_possible[$firstkey];
                    }
                }

                

                ?>
                <thead>
                    <tr>
                        <th><b>Récapitulatif de la commande</b></th>
                    </tr>
                </thead>
                    <tr>
                        <td>Date de début</td>
                        <td>Numéro du chalet</td>
                        <td>Saison</td>
                        <td>Prix</td>
                    </tr>
                    <?php
                    $i=0;
                    Foreach($prix_semaine as $prixsemaine){
                        echo "<tr>";
                        echo "<td>samedi $array_date_str_clean[$i]</td>";
                        echo "<td>Chalet numéro $chalet_choisi[$i]</td>";
                        echo "<td>$saison_semaine[$i]</td>";
                        echo "<td>$prixsemaine</td>";
                        echo "</tr>";
                        $i++;
                    }
                    echo "<tr>";
                    echo "<td></td>";
                    echo "<td></td>";
                    echo "<td>TOTAL</td>";
                    echo "<td>$prix_total euros</td>";
                    echo "</tr>";
                    echo "</table>";


                    //On confirme la commande :
                    ?>
                    
                                <form action="./reserver.php" method="GET">
                                    <input type="hidden" name="c" value="resa">
                                    <input type="hidden" name="nbr_semaine" value="<?php echo $_GET['nbr_semaine'];?>">
                                    <?php 
                                        $i=0;
                                        Foreach($prix_semaine as $prixsemaine){
                                            echo '<input type="hidden" name="semaine'. $i.'" value="'. $array_date_str[$i] .'">';
                                            echo '<input type="hidden" name="chalet'. $i.'" value="'. $chalet_choisi[$i] .'">';
                                            echo '<input type="hidden" name="prix'. $i .'" value="'. $prixsemaine .'">'; 
                                            $i++;                                       
                                        }
                                    ?>
                                    <input type="submit" value="Valider votre commande">
                            </form>
                        </div>
                    </div>
                </div>
                <?php

                

                
                //On enregistre la résa

                       
                break;
            
            default :
                $today = date('Y-m-d');
                ?>
                <!-- Formulaire pour demander la réservation -->
                <form action="./reserver.php" method="get">
                    <label for="date">Entrez la date du premier samedi de votre reservation :</label>
                    <input type="date" id="date" name="date" required min="<?php echo $today?>" <?php if(isset($_GET['date'])){ echo "value=". $_GET['date'];}?>><br><br>
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
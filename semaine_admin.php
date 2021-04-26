<?php
    include("./session.php");
    include("../connexion.php");
    if(!isset($_GET['c'])){
        $_GET['c']="default";
    }
    $today = date("Y-m-d");
    if(!isset($_GET['date_debut'])){
        $_GET['date_debut']=$today;
    }
    if(!isset($_GET['date_fin'])){
        $sql='SELECT MAX(date_debut) as datemax from semaine';
        $resultat = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($resultat);
        $_GET['date_fin']=$row['datemax'];

    }
    if(!isset($_GET['saison'])){
        $_GET['saison']="";
    }
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Circuits</title>
    <link rel="stylesheet" href="styles.css" />

</head>

<body>

    <?php
    include("./en-tete.php");
    //ici on se connecte a la base sql
    include("./menu.php");

    switch ($_GET['c']) {

        case 'update':
            $sql = "UPDATE semaine SET id_saison= " . $_GET['saison'] ." WHERE id_semaine =" . $_GET['id_semaine'];
            $stmt = mysqli_query($conn, $sql);
            if ($stmt == FALSE) {
                die("<br>Echec d'execution de la requete : " . $sql);
            } else {
                echo "Enregistrement mis à jour<br><br>";
                echo '<a href="./semaine_admin.php?c=default">Retour à la page des semaines</a>';
            }
            break;

        case 'read':
            $sql = "SELECT * FROM semaine WHERE id_semaine=" . $_GET['id_semaine'];
            $resultat = mysqli_query($conn, $sql);
            if ($resultat == FALSE) {
                die("<br>Echec d'execution de la requete : " . $sql);
            } elseif (mysqli_num_rows($resultat) == 1) {
                $row = mysqli_fetch_assoc($resultat);
                $newDate = date("d-m-Y", strtotime($row['date_debut']));
                echo "La semaine commençant le " . $newDate . "<br><br> Vous pouvez modifier la saison associée :";
            ?>
                <form action="./semaine_admin.php" method="get">
                    <label for="Saison"> Saison :</label>
                    <SELECT name="saison">
                        <OPTION value="1" <?php if($_GET['saison']==1){echo "selected";} ?> >Basse
                        <OPTION value="2" <?php if($_GET['saison']==2){echo "selected";} ?> >Moyenne
                        <OPTION value="3" <?php if($_GET['saison']==3){echo "selected";} ?> >Haute
                    <input type="hidden" name="id_semaine" value="<?php echo $row['id_semaine'] ?>">
                    <input type="hidden" name="c" value="update">
                    <input type="submit" value="Valider">
                </form>

            <?php
            break;
            }
        default:

            // On transforme la date en paramètre au samedi d'avant.
                $date_debut = new DateTime ($_GET['date_debut']);
                $jour_debut = $date_debut -> format ('D');
                if($jour_debut=="Mon"){
                    $date_debut->sub(new DateInterval('P2D'));
                }elseif($jour_debut=="Tue"){
                    $date_debut->sub(new DateInterval('P3D'));
                }elseif($jour_debut=="Wed"){
                    $date_debut->sub(new DateInterval('P4D'));
                }elseif($jour_debut=="Thu"){
                    $date_debut->sub(new DateInterval('P5D'));
                }elseif($jour_debut=="Fri"){
                    $date_debut->sub(new DateInterval('P6D'));
                }elseif($jour_debut=="Sun"){
                    $date_debut->sub(new DateInterval('P1D'));
                }

                $date_fin = new DateTime ($_GET['date_fin']);
                $jour_fin = $date_fin -> format ('D');
                if($jour_fin=="Mon"){
                    $date_fin->sub(new DateInterval('P2D'));
                }elseif($jour_fin=="Tue"){
                    $date_fin->sub(new DateInterval('P3D'));
                }elseif($jour_fin=="Wed"){
                    $date_fin->sub(new DateInterval('P4D'));
                }elseif($jour_fin=="Thu"){
                    $date_fin->sub(new DateInterval('P5D'));
                }elseif($jour_fin=="Fri"){
                    $date_fin->sub(new DateInterval('P6D'));
                }elseif($jour_fin=="Sun"){
                    $date_fin->sub(new DateInterval('P1D'));
                }
                $strdate_debut = $date_debut->format('Y-m-d');
                $strdate_fin = $date_fin->format('Y-m-d');
            ?>
            
            <table border=1>
                <tr>
                    <form action="./semaine_admin.php?" method="GET">
                            <td><label for="date_debut">Date de début</label></td>
                            <td><input type="date" id="date_debut" name="date_debut" value="<?php echo $_GET['date_debut'] ?>"></td>
                            <td><label for="date_fin">Date de fin</label></td>
                            <td><input type="date" id="date_fin" name="date_fin" value="<?php echo $_GET['date_fin'] ?>"></td>
                            <td><SELECT name="saison">
                                <OPTION value="">--Saison--</option>
                                <OPTION value="1">Basse
                                <OPTION value="2">Moyenne
                                <OPTION value="3">Haute
                            </SELECT></td>                     
                            <td><input type="submit" value="Rechercher"></td>
                    </form>
                </tr>
            </table>

            <br><br>

            <?php
            
            if (empty($_GET['saison'])){
                $sql = "SELECT * FROM Semaine inner join saison on semaine.id_saison=saison.id_saison WHERE semaine.date_debut >='" . $strdate_debut . "' AND semaine.date_debut <='" . $strdate_fin . "' ORDER BY date_debut";
            }else{
                $sql = "SELECT * FROM Semaine inner join saison on semaine.id_saison=saison.id_saison WHERE semaine.date_debut >='" . $strdate_debut . "' AND semaine.date_debut <='" . $strdate_fin . "' AND semaine.id_saison=" . $_GET['saison'] . " ORDER BY date_debut";
            }
            
            $resultat = mysqli_query($conn, $sql);
            if ($resultat == FALSE) {
                die("<br>Echec d'execution de la requete : " . $sql);
            } elseif (mysqli_num_rows($resultat) == 1) {
                $row = mysqli_fetch_assoc($resultat);
            }
            ?>
            <div class="container">
                <div class="row align-items-center">
                    <div class="col align-self-center">
                        <p><br><a href='./ajout_semaines.php'>Ajouter</a></p>

                                    <table class="table table-striped">
                                        <tr>
                                            <td>Date de début</td>
                                            <td>Saison</td>
                                            <td>Taux</td>
                                            <td></td>
                                        </tr>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($resultat)) {
                                        $newDate = date("d-m-Y", strtotime($row['date_debut']));                            
                                        echo "<tr>";
                                            echo "<td>" . $newDate . "</td>";
                                            echo "<td>" . $row['type'] . "</td>";
                                            echo "<td>" . $row['taux'] . "</td>";

                                            echo "<td><a href=./semaine_admin.php?c=read&id_semaine=" . $row['id_semaine']. '&saison='. $row['id_saison'] . ">éditer</a></td>";
                                    }
                                        echo "</tr>";
                                
                                    echo "</table>";
                                    ?>
                    </div>
                </div>
            </div>
            <?php
            break;
    }
            ?>
    </body>
<?php
include("./footer.html");
?>

</html>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Circuits</title>
    <link rel="stylesheet" href="styles.css" />

</head>

<body>

    <?php
    include('./session.php');
    include("./en-tete.php");
    //ici on se connecte a la base sql
    include("../connexion.php");
    include("./menu.php");

    switch ($_GET['c']) {



        case 'update':

            if (isset($_GET['date'])) {
                $date = new DateTime($_GET['date']);
                $jour = $date->format('D');
                //on lance la requete si le jour est bien un samedi
                if ($jour == "Sat") {

                    $sql = "SELECT * from semaine where date_debut='" . $_GET['date'] . "'";
                    $resultat = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($resultat);
                    $id_semaine = $row['id_semaine'];

                    $sql = "SELECT * from prix_special where id_chalet=" . $_GET['id_chalet'] . " and id_semaine=" . $id_semaine;
                    $resultat = mysqli_query($conn, $sql);
                    if ($resultat) {
                        if (mysqli_num_rows($resultat) == 1) {
                        $sql = "UPDATE prix_special SET id_chalet='" . $_GET['id_chalet'] . "', id_semaine='" . $id_semaine . "', prix_modifie='" . $_GET['prix_modifie'] . "' where id_chalet='" . $_GET['id_chalet'] . "'";
                        $stmt = mysqli_query($conn, $sql);
                        if ($stmt == FALSE) {
                            die("<br>Echec d'execution de la requete : " . $sql);
                        } else {
                            echo "Enregistrement mis à jour<br><br>";
                            echo '<a href="./chalet_admin.php?c=default">Retour aux chalets</a>';
                        }
                    }else {
                        $sql = "INSERT INTO prix_special (id_chalet, id_semaine, prix_modifie) values ('" . $_GET['id_chalet'] . "','" . $id_semaine . "', '" . $_GET['prix_modifie'] . "' )";
                        $resultat = mysqli_query($conn, $sql);
                        if ($resultat == FALSE) {
                            die("<br>Echec d'execution de la requete : " . $sql);
                        } else {
                            echo "Ajout OK !";
                            echo "Enregistrement mis à jour<br><br>";
                            echo '<a href="./chalet_admin.php?c=default">Retour aux chalets</a>';
                        }

                     }
            
                    }


                } else { /// si c'est pas un samedi alors redirect
                    echo "tu n'as pris un samedi";
                    echo "<a href=./modif_chalet_semaine.php?c=default&id_chalet=" . $_GET['id_chalet'] . ">retour à la modif</a>";
                }
            }
            break;



        default:

    ?>

            <form action="./modif_chalet_semaine.php" method="get">

                <label for="nom">Prix du chalet :</label>
                <input type="text" id="prix_modifie" name="prix_modifie"><br><br>


                <label for="date">Pour quelle semaine ?</label>
                <input type="date" id="date" name="date"><br><br>


                <input type="hidden" name="c" value="update">
                <input type="hidden" name="id_chalet" value="<?php echo $_GET['id_chalet'] ?>">

                <input type="submit" value="Appuie pour faire les changements">
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
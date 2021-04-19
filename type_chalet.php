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


        case 'create':
    ?>
            <form action="./type_chalet.php" method="get">

                <label for="libelle">libelle :</label>
                <input type="text" id="libelle" name="libelle"><br><br>
                <label for="prix_base">Prix de base :</label>
                <input type="text" id="prix_base" name="prix_base"><br><br>
                <label for="mail">nombre de place :</label>
                <input type="text" id="nb_place" name="nb_place"><br><br>
                <input type="hidden" name="c" value="add">
                <input type="submit" value="Envoyer">
            </form>

            <?php
            break;

        case 'add':
            foreach ($_GET as $key => $Value) {
                if (empty($Value)) {
                    die("Il manque une valeur pour " . $key);
                }
            }
            $sql = "INSERT INTO type_chalet (libelle, prix_base, nb_place) values ('" . $_GET['libelle'] . "','" . $_GET['prix_base'] . "','" . $_GET['nb_place'] . "')";
            $resultat = mysqli_query($conn, $sql);
            if ($resultat == FALSE) {
                die("<br>Echec d'execution de la requete : " . $sql);
            } else {
                echo "Ajout OK !";
            }
            break;

        case 'read':

            $sql = "SELECT * FROM type_chalet WHERE id_type_chalet=" . $_GET['id_type_chalet'];
            $resultat = mysqli_query($conn, $sql);
            if ($resultat == FALSE) {
                die("<br>Echec d'execution de la requete : " . $sql);
            } elseif (mysqli_num_rows($resultat) == 1) {
                $row = mysqli_fetch_assoc($resultat);
            ?>
                <form action="./type_chalet.php" method="get">
                    <label for="libelle">libelle :</label>
                    <input type="text" id="libelle" name="libelle" value="<?php echo $row['libelle'] ?>"><br><br>
                    <label for="prix_base">Prix de base :</label>
                    <input type="text" id="prix_base" name="prix_base" value="<?php echo $row['prix_base'] ?>"><br><br>
                    <label for="mail">nombre de place :</label>
                    <input type="text" id="nb_place" name="nb_place" value="<?php echo $row['nb_place'] ?>"><br><br>
                    <input type="hidden" name="id_type_chalet" value="<?php echo $row['id_type_chalet'] ?>">
                    <input type="hidden" name="c" value="update">
                    <input type="submit" value="Envoyer">
                </form>
            <?php
            }
            break;

        case 'update':

            foreach ($_GET as $key => $Value) {
                if (empty($Value)) {
                    die("Il manque une valeur pour " . $key);
                }
            }
            $sql = "UPDATE type_chalet SET libelle='" . $_GET['libelle'] . "', prix_base='" . $_GET['prix_base'] . "',nb_place='" . $_GET['nb_place'] . "' where id_type_chalet=" . $_GET['id_type_chalet'];
            $resultat = mysqli_query($conn, $sql);
            if ($resultat == FALSE) {
                die("<br>Echec d'execution de la requete : " . $sql);
            } else {
                echo "Enregistrement mis à jour";
            }
            break;

        case 'del':
            $sql = "DELETE FROM type_chalet where id_type_chalet='" . $_GET['id_type_chalet'] . "'";
            $resultat = mysqli_query($conn, $sql);
            if ($resultat == FALSE) {
                die("<br>Echec d'execution de la requete : " . $sql);
            } else {
                echo "Enregistrement supprimé";
            }
            break;



        default: //liste les enregistrements

            $sql = 'SELECT * FROM type_chalet';
            $resultat = mysqli_query($conn, $sql);
            if ($resultat == FALSE) {
                die("<br>Echec d'execution de la requete : " . $sql);
            } else {

            ?>

                <div class="container">
                    <div class="row align-items-center">
                        <div class="col align-self-center">
                            <p>Liste des chalets</p>
                            <p><br><a href='./type_chalet.php?c=create'>Ajouter</a></p>

                            <table class="table table-striped">
                                <tr>
                                    <td>libelle</td>
                                    <td>Prix de base</td>
                                    <td>nombre de place</td>
                                    <td></td>
                                    <td></td>
                                </tr>



                            <?php
                            while ($row = mysqli_fetch_assoc($resultat)) {
                                echo "<tr>";
                                echo "<td>" . $row['libelle'] . "</td>";
                                echo "<td>" . $row['prix_base'] . "</td>";
                                echo "<td>" . $row['nb_place'] . "</td>";
                                echo "<td><a href=./type_chalet.php?c=del&id_type_chalet=" . $row['id_type_chalet'] . ">supprimer</a></td>";
                                echo "<td><a href=./type_chalet.php?c=read&id_type_chalet=" . $row['id_type_chalet'] . ">éditer</a></td>";
                            }
                            echo "</tr>";
                        }
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
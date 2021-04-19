<!DOCTYPE html>
<html lang="fr">

<head>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client admin</title>
    <link rel="stylesheet" href="index.css" />
</head>

<body>

    <?php
    include('./session.php');
    include("./en-tete.php");
    //ici on se connecte a la base sql
    include("../connexion.php");
    include("./menu.php");


    switch ($_GET['c']) {

        case 'read':

            $sql = "SELECT * FROM saison WHERE id_saison=" . $_GET['id_saison'];
            $resultat = mysqli_query($conn, $sql);
            if ($resultat == FALSE) {
                die("<br>Echec d'execution de la requete : " . $sql);
            } elseif (mysqli_num_rows($resultat) == 1) {
                $row = mysqli_fetch_assoc($resultat);
    ?>
                <div class="container">
                    <form action="./saisons.php" method="get">
                        <label for="nom">Type : <?php echo $row['type'] ?> </label>
                        <br><br>
                        <label for="prenom">Taux :</label>
                        <input type="text" id="taux_saison" name="taux_saison" value="<?php echo $row['taux'] ?>"><br><br>



                        <input type="hidden" name="id_saison" value="<?php echo $row['id_saison'] ?>">

                        <input type="hidden" name="c" value="update">

                        <input type="submit" value="Envoyer">
                    </form>
                </div>
            <?php
            }
            break;

        case 'update':

            $sql = "UPDATE saison SET taux='" . $_GET['taux_saison'] . "' where id_saison=" . $_GET['id_saison'];
            $stmt = mysqli_query($conn, $sql);
            if ($stmt == FALSE) {
                die("<br>Echec d'execution de la requete : " . $sql);
            } else {
                echo "Enregistrement mis à jour<br><br>";
                echo '<a href="./saisons.php?c=default">Retour aux saisons</a>';
            }
            break;


        default: //liste les enregistrements

            $sql = 'SELECT * FROM saison';
            $resultat = mysqli_query($conn, $sql);
            if ($resultat == FALSE) {
                die("<br>Echec d'execution de la requete : " . $sql);
            } else {

            ?>
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col align-self-center">

                            <table class="table table-striped">
                                <tr>
                                    <th>Type</th>
                                    <th>Taux</th>

                                </tr>
                            <?php
                            while ($row = mysqli_fetch_assoc($resultat)) {
                                echo "<tr>";
                                echo "<td>" . $row['type'] . "</td>";
                                echo "<td>" . $row['taux'] . "</td>";

                                echo "<td><a href=./saisons.php?c=read&id_saison=" . $row['id_saison'] . ">éditer</a></td>";
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
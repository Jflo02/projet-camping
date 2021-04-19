<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <meta charset="utf-8" />
    <title>Circuits</title>
    <link rel="stylesheet" href="index.css" />

</head>

<body>

    <?php
    include('./session.php');
    include("./en-tete.php");
    include("./menu.php");
    include("../connexion.php");





    ?>
    <div class="container">

        <?php

        switch ($_GET['c']) {
            case 'modif':
                foreach ($_GET as $key => $Value) {
                    if (empty($Value)) {
                        die("Il manque une valeur pour " . $key);
                    }
                }
                $sql = "UPDATE client SET nom='" . $_GET['nom_pers'] . "', prenom='" . $_GET['prenom_pers'] . "',date_naissance='" . $_GET['DN_pers'] . "',mail='" . $_GET['mail'] . "', telephone='" . $_GET['telephone'] . "', adresse='" . $_GET['adresse'] . "', cp_ville='" . $_GET['cp_ville'] . "' , mdp_client='" . $_GET['mdp_pers'] . "', ville='" . $_GET['ville'] . "' where id_client=" . $_GET['id_client'];
                $stmt = mysqli_query($conn, $sql);
                if ($stmt == FALSE) {
                    die("<br>Echec d'execution de la requete : " . $sql);
                } else {
                    echo "Enregistrement mis à jour<br><br>";
                    echo '<a href="./mon_compte.php?c=default">Retour à mon compte</a>';
                }
                break;

            default:
                echo '<a href="./Histo_resa.php">Voir mes réservations</a>';
                echo "<br><br>";
                $sql = "SELECT * FROM client WHERE id_client=" . $_SESSION['id_user'];
                $stmt = mysqli_query($conn, $sql);
                if ($stmt == FALSE) {
                    die("<br>Echec d'execution de la requete : " . $sql);
                } else {

                    while ($row = mysqli_fetch_array($stmt)) {
                        $str_date = $row['date_naissance'];
        ?>
                        <div class="container">
                            <form action="./mon_compte.php" method="get">
                                <label for="nom">Nom :</label>
                                <input type="text" id="nom_pers" name="nom_pers" value="<?php echo $row['nom'] ?>"><br><br>

                                <label for="prenom">Prénom :</label>
                                <input type="text" id="prenom_pers" name="prenom_pers" value="<?php echo $row['prenom'] ?>"><br><br>

                                <label for="DN">Date de naissance :</label>
                                <input type="date" id="DN_pers" name="DN_pers" value="<?php echo $str_date ?>"><br><br>

                                <label for="mail">Mail :</label>
                                <input type="mail" id="mail" name="mail" value="<?php echo $row['mail'] ?>"><br><br>

                                <label for="telephone">telephone :</label>
                                <input type="telephone" id="telephone" name="telephone" value="<?php echo $row['telephone'] ?>"><br><br>

                                <label for="adresse">adresse :</label>
                                <input type="text" id="adresse" name="adresse" value="<?php echo $row['adresse'] ?>"><br><br>

                                <label for="cp_ville">cp_ville :</label>
                                <input type="text" id="cp_ville" name="cp_ville" value="<?php echo $row['cp_ville'] ?>"><br><br>

                                <label for="password">Mot de passe :</label>
                                <input type="password" id="mdp_pers" name="mdp_pers" value="<?php echo $row['mdp_client'] ?>"><br><br>
                                <p>8 caractères d'au moins un chiffre et une lettre majuscule et minuscule</p>

                                <label for="Ville">Ville :</label>
                                <input type="text" id="ville" name="ville" value="<?php echo $row['ville'] ?>"><br><br>



                                <input type="hidden" name="id_client" value="<?php echo $row['id_client'] ?>">

                                <input type="hidden" name="c" value="modif">

                                <input type="submit" value="Appuie pour faire les changements">
                            </form>
                        </div>
        <?php
                    }
                }
        }

        ?>


    </div>
    <!--On ferme le div du corps -->
</body>
<?php
include("./footer.html");
?>

</html>
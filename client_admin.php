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
            <form action="./client_admin.php" method="get">
                <label for="nom">Nom :</label>
                <input type="text" id="nom_pers" name="nom_pers"><br><br>

                <label for="prenom">Prénom :</label>
                <input type="text" id="prenom_pers" name="prenom_pers"><br><br>

                <label for="DN">Date de naissance :</label>
                <input type="date" id="DN_pers" name="DN_pers"><br><br>

                <label for="mail">Mail :</label>
                <input type="mail" id="mail" name="mail"><br><br>

                <label for="telephone">telephone :</label>
                <input type="telephone" id="telephone" name="telephone"><br><br>

                <label for="adresse">adresse :</label>
                <input type="text" id="adresse" name="adresse"><br><br>

                <label for="cp_ville">code postal :</label>
                <input type="text" id="cp_ville" name="cp_ville"><br><br>

                <label for="password">Mot de passe :</label>
                <input type="password" id="mdp_pers" name="mdp_pers"><br><br>

                <label for="Ville">Ville :</label>
                <input type="text" id="ville" name="ville"><br><br>

                <input type="hidden" name="c" value="add">

                <input type="submit" value="Appuie pour faire les changements">
            </form>


            <?php
            break;

        case 'add':

            $sql = "INSERT INTO client (nom, prenom, date_naissance, mail, telephone, adresse, cp_ville, mdp_client, ville) values ('" . $_GET['nom_pers'] . "','" . $_GET['prenom_pers'] . "','" . $_GET['DN_pers'] . "','" . $_GET['mail'] . "','" . $_GET['telephone'] . "','" . $_GET['adresse'] . "','" . $_GET['cp_ville'] . "','" . $_GET['mdp_pers'] . "','" . $_GET['ville'] . "')";
            $resultat = mysqli_query($conn, $sql);
            if ($resultat == FALSE) {
                die("<br>Echec d'execution de la requete : " . $sql);
            } else {
                echo "Ajout OK !";
                echo "Enregistrement mis à jour<br><br>";
                echo '<a href="./client_admin.php?c=default">Retour aux clients</a>';
            }
            break;

        case 'read':

            $sql = "SELECT * FROM client WHERE id_client=" . $_GET['id_client'];
            $resultat = mysqli_query($conn, $sql);
            if ($resultat == FALSE) {
                die("<br>Echec d'execution de la requete : " . $sql);
            } elseif (mysqli_num_rows($resultat) == 1) {
                $row = mysqli_fetch_assoc($resultat);
            ?>
                <form action="./client_admin.php" method="get">
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

                    <label for="cp_ville">code postal :</label>
                    <input type="text" id="cp_ville" name="cp_ville" value="<?php echo $row['cp_ville'] ?>"><br><br>

                    <label for="Ville">Ville :</label>
                    <input type="text" id="ville" name="ville" value="<?php echo $row['ville'] ?>"><br><br>

                    <input type="hidden" name="id_client" value="<?php echo $row['id_client'] ?>">

                    <input type="hidden" name="c" value="update">

                    <input type="submit" value="Appuie pour faire les changements">
                </form>
            <?php
            }
            break;

        case 'update':

            $sql = "UPDATE client SET nom='" . $_GET['nom_pers'] . "', prenom='" . $_GET['prenom_pers'] . "',date_naissance='" . $_GET['DN_pers'] . "',mail='" . $_GET['mail'] . "', telephone='" . $_GET['telephone'] . "', adresse='" . $_GET['adresse'] . "', cp_ville='" . $_GET['cp_ville'] . "', ville='" . $_GET['ville'] . "' where id_client=" . $_GET['id_client'];
            $stmt = mysqli_query($conn, $sql);
            if ($stmt == FALSE) {
                die("<br>Echec d'execution de la requete : " . $sql);
            } else {
                echo "Enregistrement mis à jour<br><br>";
                echo '<a href="./client_admin.php?c=default">Retour aux clients</a>';
            }
            break;

        case 'del':
            $sql = "DELETE FROM client where id_client='" . $_GET['id_client'] . "'";
            $resultat = mysqli_query($conn, $sql);
            if ($resultat == FALSE) {
                die("<br>Echec d'execution de la requete : " . $sql);
            } else {
                echo "Enregistrement supprimé";
            }
            break;



        default: //liste les enregistrements

            $sql = 'SELECT * FROM client';
            $resultat = mysqli_query($conn, $sql);
            if ($resultat == FALSE) {
                die("<br>Echec d'execution de la requete : " . $sql);
            } else {

            ?>
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col align-self-center">
                            <p>Liste des clients</p>
                            <p><br><a href='./client_admin.php?c=create'>Ajouter</a></p>

                            <table class="table table-striped">
                                <tr>
                                    <td>nom</td>
                                    <td>prenom</td>
                                    <td>date_naissance</td>
                                    <td>mail</td>
                                    <td>téléphne</td>
                                    <td>adresse</td>
                                    <td>code postale</td>
                                    <td>Ville</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            <?php
                            while ($row = mysqli_fetch_assoc($resultat)) {
                                echo "<tr>";
                                echo "<td>" . $row['nom'] . "</td>";
                                echo "<td>" . $row['prenom'] . "</td>";
                                echo "<td>" . $row['date_naissance'] . "</td>";
                                echo "<td>" . $row['mail'] . "</td>";
                                echo "<td>" . $row['telephone'] . "</td>";
                                echo "<td>" . $row['adresse'] . "</td>";
                                echo "<td>" . $row['cp_ville'] . "</td>";
                                echo "<td>" . $row['ville'] . "</td>";

                                echo "<td><a href=./client_admin.php?c=del&id_client=" . $row['id_client'] . ">supprimer</a></td>";
                                echo "<td><a href=./client_admin.php?c=read&id_client=" . $row['id_client'] . ">éditer</a></td>";
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

</html>
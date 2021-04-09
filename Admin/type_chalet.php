<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Circuits</title>
    <link rel="stylesheet" href="styles.css" />

</head>

<body>

    <?php 
    include("../en-tete.php");
    //ici on se connecte a la base sql
    include("../../connexion.php");

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

        $sql = "SELECT * FROM type_chalet WHERE id_etu=" . $_GET['id_etu'];
        $resultat = mysqli_query($conn, $sql);
        if ($resultat == FALSE) {
            die("<br>Echec d'execution de la requete : " . $sql);
        } elseif (mysqli_num_rows($resultat) == 1) {
            $row = mysqli_fetch_assoc($resultat);
        ?>
            <form action="./index.php" method="get">
                <label for="nom">Nom :</label>
                <input type="text" id="nom_etu" name="nom_etu" value="<?php echo $row['nom_etu'] ?>"><br><br>
                <label for="prenom">Prénom :</label>
                <input type="text" id="prenom_etu" name="prenom_etu" value="<?php echo $row['prenom_etu'] ?>"><br><br>
                <label for="mail">Mail :</label>
                <input type="text" id="mail_etu" name="mail_etu" value="<?php echo $row['mail_etu'] ?>"><br><br>
                <label for="mail">Mot de passe :</label>
                <input type="text" id="mdp_etu" name="mdp_etu" value="<?php echo $row['mdp_etu'] ?>"><br><br>
                <input type="hidden" name="id_etu" value="<?php echo $row['id_etu'] ?>">
                <input type="hidden" name="c" value="e">
                <input type="hidden" name="do" value="update">
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
        $sql = "UPDATE etudiants SET nom_etu='" . $_GET['nom_etu'] . "', prenom_etu='" . $_GET['prenom_etu'] . "',mail_etu='" . $_GET['mail_etu'] . "',mdp_etu='" . $_GET['mdp_etu'] . "' where id_etu=" . $_GET['id_etu'];
        $resultat = mysqli_query($conn, $sql);
        if ($resultat == FALSE) {
            die("<br>Echec d'execution de la requete : " . $sql);
        } else {
            echo "Enregistrement mis à jour";
        }
        break;
    
    case 'del':
        break;



    default: //liste les enregistrements
        
        $sql = 'SELECT * FROM type_chalet';
        $resultat = mysqli_query($conn, $sql);
        if ($resultat == FALSE) {
            die("<br>Echec d'execution de la requete : " . $sql);
        } else {
            echo "Liste des chalet";
            echo "<br><a href='./type_chalet.php?c=create'>Ajouter</a>";
        ?>
            
            <table border=1>
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
                echo "<td><a href=./type_chalet.php?c=del&id_etu=" . $row['id_type_chalet'] . ">supprimer</a></td>";
                echo "<td><a href=./type_chalet.php?c=read&id_etu=" . $row['id_type_chalet'] . ">éditer</a></td>";
                }
                echo "</tr>";
            }
            echo "</table>";

    break;
        }

                            ?>



</body>

</html>
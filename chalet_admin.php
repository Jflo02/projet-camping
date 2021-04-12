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
    include("../connexion.php");

    switch ($_GET['c']) {

        case 'add':
            break;

        
        default:
        $sql = 'SELECT libelle, prix_base, id_chalet FROM type_chalet INNER JOIN chalet on type_chalet.id_type_chalet=chalet.id_type_chalet';
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
                                <td>libelle</td>
                                <td>prix</td>
                                <td>id_chalet</td>
                                <td></td>
                            </tr>
                        <?php
                        while ($row = mysqli_fetch_assoc($resultat)) {
                            echo "<tr>";
                            echo "<td>" . $row['libelle'] . "</td>";
                            echo "<td>" . $row['prix_base'] . "</td>";
                            echo "<td>" . $row['id_chalet'] . "</td>";
                            echo "<td><a href=./client_admin.php?c=del&id_client=" . $row['id_chalet'] . ">supprimer</a></td>";
                            echo "<td><a href=./client_admin.php?c=read&id_client=" . $row['id_chalet'] . ">éditer</a></td>";
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






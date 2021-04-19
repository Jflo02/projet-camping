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

            <p> Quel est le type du nouveau Chalet:
                <br></br>
            <form action="./chalet_admin.php" method="get">
                <label for="libelle">Mini :</label>
                <input type="radio" id="id_type_chalet" name="id_type_chalet" value="1" checked><br><br>

                <label for="libelle">Grand :</label>
                <input type="radio" id="id_type_chalet" name="id_type_chalet" value="2"><br><br>

                <label for="libelle">Grand Luxe :</label>
                <input type="radio" id="id_type_chalet" name="id_type_chalet" value="3"><br><br>
                <input type="hidden" name="c" value="add">
                <input type="submit" value="Appuie">
            </form>
            </form>
            </p>

        <?php
            break;
        case 'add':

            $sql = "INSERT INTO chalet (id_type_chalet) values ('" . $_GET['id_type_chalet'] . "')";
            $resultat = mysqli_query($conn, $sql);
            if ($resultat == FALSE) {
                die("<br>Echec d'execution de la requete : " . $sql);
            } else {
                echo "Ajout OK !";
                echo "Enregistrement mis à jour<br><br>";
                echo '<a href="./chalet_admin.php?c=default">Retour aux chalets</a>';
            }

            break;


        case 'read':
            echo $_GET['id_chalet'];
        ?>
            <form action="./chalet_admin.php" method="get">

                <label for="libelle">Mini :</label>
                <input type="radio" id="id_type_chalet" name="id_type_chalet" value="1" checked><br><br>

                <label for="libelle">Grand :</label>
                <input type="radio" id="id_type_chalet" name="id_type_chalet" value="2"><br><br>

                <label for="libelle">Grand Luxe :</label>
                <input type="radio" id="id_type_chalet" name="id_type_chalet" value="3"><br><br>
        
                <input type="hidden" name="id_chalet" value="<?php echo $_GET['id_chalet'] ?>">
                <input type="hidden" name="c" value="update">

                <input type="submit" value="Appuie pour faire les changements">
            </form>

            <?php
            break;
        
        case 'update':
            echo $_GET['id_chalet'];

            $sql = "UPDATE chalet SET id_type_chalet='" . $_GET['id_type_chalet'] . "' where id_chalet='" . $_GET['id_chalet']."'";
            echo $sql;
            $stmt = mysqli_query($conn, $sql);
            if ($stmt == FALSE) {
                die("<br>Echec d'execution de la requete : " . $sql);
            } else {
                echo "Enregistrement mis à jour<br><br>";
                echo '<a href="./chalet_admin.php?c=default">Retour aux chalets</a>';
            }
            break;





        case 'del':

            $sql = "DELETE from chalet where id_chalet='" . $_GET['id_chalet'] . "'";
            $resultat = mysqli_query($conn, $sql);
            if ($resultat == FALSE) {
                die("<br>Echec d'execution de la requete : " . $sql);
            }else {
                echo "Enregistrement mis à jour<br><br>";
                echo '<a href="./chalet_admin.php?c=default">Retour aux chalets</a>';
            }
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
                            <p><br><a href='./chalet_admin.php?c=create'>Ajouter</a></p>

                            <table class="table table-striped">
                                <tr>
                                    <td>libelle</td>
                                    <td>prix</td>
                                    <td>numéro du chalet</td>
                                    <td></td>
                                </tr>
                            <?php
                            while ($row = mysqli_fetch_assoc($resultat)) {
                                echo "<tr>";
                                echo "<td>" . $row['libelle'] . "</td>";
                                echo "<td>" . $row['prix_base'] . "</td>";
                                echo "<td>" . $row['id_chalet'] . "</td>";
                                echo "<td><a href=./chalet_admin.php?c=del&id_chalet=" . $row['id_chalet'] . ">supprimer</a></td>";
                                echo "<td><a href=./chalet_admin.php?c=read&id_chalet=" . $row['id_chalet'] . ">éditer</a></td>";
                                echo "<td><a href=./modif_chalet_semaine.php?c=default&id_chalet=" . $row['id_chalet'] . ">modifier le prix du chalet</a></td>";
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
    include("./footer.html")
?>

</html>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Reservations Admin</title>
    <link rel="stylesheet" href="styles.css" />

</head>

<body>

    <?php
    include('./session.php');
    include("./en-tete.php");
    //ici on se connecte a la base sql
    include("../connexion.php");
    include("./menu.php");


    if (isset($_GET['id_chalet']) && isset($_GET['id_semaine']) && isset($_GET['c'])) {


        switch ($_GET['c']) {



            case 'update':


                break;


            default:


                $sql = 'SELECT * FROM reservation where id_chalet= ' . $_GET['id_chalet'] . ' AND id_semaine= ' . $_GET['id_semaine'];
                $resultat = mysqli_query($conn, $sql);


                while ($row = mysqli_fetch_assoc($resultat)) {



                    echo 'Etat :<br>';

                    $validation = $row['valide'];

                    

                    if ($validation === NULL) {
                        echo '<td>' . 'Pas traité' . '</td>';
                    } elseif ($validation == TRUE) {
                        echo '<td>' . 'Validée' . '</td>';
                    } elseif ($validation == FALSE) {
                        echo '<td>' . 'Invalide' . '</td>';
                    }

                    echo '<br>';
    ?>
                    <form action="./chalet_admin.php" method="get">

                        <label for="libelle">Valide :</label>
                        <input type="radio" id="etat_resa" name="etat_resa" value="1" ><br><br>

                        <label for="libelle">Invalide :</label>
                        <input type="radio" id="etat_resa" name="etat_resa" value="2"><br><br>

                        <input type="hidden" name="id_chalet" value="<?php echo $_GET['id_chalet'] ?>">
                        <input type="hidden" name="id_semaine" value="<?php echo $_GET['id_semaine'] ?>">

                        <input type="hidden" name="c" value="update">

                        <input type="submit" value="Envoyer">
                    </form>
    <?php



                }
                break;
        }
    }









    ?>
</body>
<?php
include("./footer.html");
?>

</html>
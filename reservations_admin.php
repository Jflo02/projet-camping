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

    switch ($_GET['c']) {




        case 'create':

    ?>

            <p> Quel est le type du nouveau Chalet:
                <br></br>
            <form action="./chalet_admin.php" method="get">
                <label for="libelle">Mini :</label>
                <input type="radio" id="id_type_chalet" name="1"><br><br>

                <label for="libelle">Grand :</label>
                <input type="radio" id="id_type_chalet" name="2"><br><br>

                <label for="libelle">Grand Luxe :</label>
                <input type="radio" id="id_type_chalet" name="3"><br><br>
                <input type="hidden" name="c" value="add">
                <input type="submit" value="Appuie">
            </form>
            </form>
            </p>

            <?php


        case 'del':

            $sql = "DELETE from chalet where id_chalet='" . $_GET['id_chalet'] . "'";
            $resultat = mysqli_query($conn, $sql);
            if ($resultat == FALSE) {
                die("<br>Echec d'execution de la requete : " . $sql);
            }
            break;



        default:
            $sql = 'SELECT * FROM reservation';
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
                                    <th>Id client</th>
                                    <th>Id Chalet</th>
                                    <th>Semaine</th>
                                    <th>Statut</th>
                                    <th>Prix</th>
                                    <th></th>
                                </tr>
                            <?php
                            while ($row = mysqli_fetch_assoc($resultat)) {
                                echo "<tr>";
                                echo "<td>" . $row['id_client'] . "</td>";
                                echo "<td>" . $row['id_chalet'] . "</td>";
                                //on affiche la semaine
                                $sql = 'SELECT * FROM semaine WHERE id_semaine=' . $row['id_semaine'];
                                $resultat = mysqli_query($conn, $sql);
                                $row_semaine = mysqli_fetch_assoc($resultat);
                                $date_debut = date("d-m-Y", strtotime($row_semaine['date_debut']));
                                $date_fin = date('d-m-Y', strtotime('+7 days', strtotime($date_debut)));
                                echo "<td> Du :<br>" . $date_debut . "<br>au :<br>" . $date_fin .  "</td>";
                                //fin affichage semaine

                                //on affiche la validation de la réservation

                                $validation = $row['valide'];
                                if ($validation === NULL) {
                                    echo '<td>' . 'Pas traité' . '</td>';
                                } elseif ($validation == TRUE) {
                                    echo '<td>' . 'Validée' . '</td>';
                                } elseif ($validation == FALSE) {
                                    echo '<td>' . 'Invalide, contacter le camping pour plus de renseignements' . '</td>';
                                }
                                echo "<td>" . $row['prix'] ."</td>";
                                //fin de la validité
                                echo "<td><a href=./reservations_admin?c=read&id_client=" . $row['id_chalet'] . ">éditer(NE MARCHE PAS/A CODER)</a></td>";
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
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Reservations</title>
</head>

<body>




    <?php
    include('./session.php');
    include("./en-tete.php");
    //ici on se connecte a la base sql
    include("../connexion.php");
    include("./menu.php");
    ?>

   

        


                    <?php

                    $sql = 'SELECT * FROM chalet inner join reservation on chalet.id_chalet = reservation.id_chalet WHERE id_client=' . $_SESSION['id_user'];
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
                                            <th>Semaine</th>
                                            <th>Numéro du chalet</th>
                                            <th>Type du chalet</th>
                                            <th>Date de réservation</th>
                                            <th>Statut</th>


                                        </tr>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($resultat)) {
                                        echo "<tr>";
                                        //on cherche le debut de la semaine
                                        $sql = 'SELECT * FROM semaine WHERE id_semaine=' . $row['id_semaine'];
                                        $resultat = mysqli_query($conn, $sql);
                                        $row_semaine = mysqli_fetch_assoc($resultat);
                                        $date_debut = date("d-m-Y", strtotime($row_semaine['date_debut'])); 
                                        $date_fin=date('d-m-Y', strtotime('+7 days', strtotime($date_debut)));
                                        echo "<td> Du :<br>" . $date_debut . "<br>au :<br>" .$date_fin .  "</td>";

                                        //fin de recherche semaine

                                        echo "<td>" . $row['id_chalet'] . "</td>";

                                        //on cherche a quel chalet correspond le type

                                        $sql = 'SELECT * FROM type_chalet WHERE id_type_chalet=' . $row['id_chalet'];
                                        $resultat = mysqli_query($conn, $sql);
                                        $row2 = mysqli_fetch_assoc($resultat);
                                        echo "<td>" . $row2['libelle'] . "</td>";

                                        //fin de la recherche

                                        $date = date("d-m-Y", strtotime($row['date_reservation']));
                                        echo "<td>" . $date . "</td>";

                                        //on affiche la validation de la réservation

                                        $validation = $row['valide'];
                                        if ($validation === NULL) {
                                            echo '<td>' . 'Pas traité' . '</td>';
                                        } elseif ($validation == TRUE) {
                                            echo '<td>' . 'Validée' . '</td>';
                                        } elseif ($validation == FALSE) {
                                            echo '<td>' . 'Invalide, contacter le camping pour plus de renseignements' . '</td>';
                                        }
                                        //fin de la validité


                                    }
                                    echo "</tr>";
                                }
                                echo "</table>";
                                    ?>

                                </div>
                            </div>
                        </div>






</body>
<?php
include("./footer.html");
?>

</html>
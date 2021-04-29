<?php
include('./session.php');
include("../connexion.php");
include("./en-tete.php");
include("./menu.php");
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="Expires" content="0">
    <title>Reservation</title>
    <link rel="stylesheet" href="styles.css" />
</head>

<body>
    <div class="container">
        <div class="row align-items-center">
            <div class="col align-self-center">
                <?php
                    $sql = 'SELECT * FROM prix_special inner join semaine on prix_special.id_semaine = semaine.id_semaine inner join chalet on prix_special.id_chalet = chalet.id_chalet WHERE id_type_chalet='. $_GET['cat']. ' and (semaine.id_semaine, chalet.id_chalet) not in (select id_semaine, id_chalet from reservation)';
                    $resultat = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($resultat)==0) {
                        echo "Il n'y a pas de promotion sur ce type de chalet, vous pouvez réserver normalement : <br><br>";
                        echo '<a href="./reserver.php?cat='. $_GET['cat'].'" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Reserver</a>';
                    }else{
                        ?>
                        <table class="table table-striped">
                        <thead>
                                <tr>
                                    <th><b>Nos Promos :</b></th>
                                </tr>
                            </thead>
                                <tr>
                                    <th>Chalet</th>
                                    <th>Semaine</th>
                                    <th>Prix</th>
                                    <th></th>
                                </tr>
                            <?php
                            while ($row = mysqli_fetch_assoc($resultat)) {
                                echo "<tr>";
                                echo "<td>" . $row['id_chalet'] . "</td>";
                                $date_debut = date("d-m-Y", strtotime($row['date_debut']));
                                $date_fin = date('d-m-Y', strtotime('+7 days', strtotime($date_debut)));
                                echo "<td> Du :<br>" . $date_debut . "<br>au :<br>" . $date_fin .  "</td>";
                                echo "<td>" . $row['prix_modifie'] . " euros !</td>";
                                echo '<td><a href="./reserver.php?cat='. $_GET['cat'].'&date='.$row['date_debut'].'" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Reserver</a></td>';
                                echo "</tr>";
                            }
                        echo "</table>";
                    }
                ?>
            </div>
        </div>
    </div>
</body>
<?php
    include("./footer.html")
    ?>
</html>
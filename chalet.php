<!DOCTYPE html>
<html lang="en">

<head>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chalet</title>
    <link rel="stylesheet" href="chalet.css" />
</head>

<body>
    <?php
    //test après les bug
    include("../connexion.php");
    include("./session.php");
    include("./en-tete.php");
    include("./menu.php");

    //on va chercher les prix des chalets dans la bdd

    //chalet mini
    $sql = 'SELECT * FROM type_chalet WHERE libelle="mini"';
    $resultat = mysqli_query($conn, $sql);
    if ($resultat) {
        if (mysqli_num_rows($resultat) == 1) {
            $row = mysqli_fetch_array($resultat);
            $prix_mini_chalet = $row['prix_base'];
        }
    }

    //chalet grand
    $sql = 'SELECT * FROM type_chalet WHERE libelle="grand"';
    $resultat = mysqli_query($conn, $sql);
    if ($resultat) {
        if (mysqli_num_rows($resultat) == 1) {
            $row = mysqli_fetch_array($resultat);
            $prix_grand_chalet = $row['prix_base'];
        }
    }

    //chalet grand luxe
    $sql = 'SELECT * FROM type_chalet WHERE libelle="grand luxe"';
    $resultat = mysqli_query($conn, $sql);
    if ($resultat) {
        if (mysqli_num_rows($resultat) == 1) {
            $row = mysqli_fetch_array($resultat);
            $prix_grand_luxe_chalet = $row['prix_base'];
        }
    }

    ?>



    <div class="container align-self-center " style="border: 1px solid black" id="chalet_mini">
        <div class="row">
            <div class="col-4 ">
                <img src="./photos/bungalow_mini.jpg" alt="Bungalow 4 personnes" width="100%">
            </div>
            <div class="col-4 ">
                <h4 class="text-center ">Bungalow mini pouvant accueillir jusqu'à 4 personnes</h4>
                <ul class="text-left ">
                    <?php
                    echo '<li>' . $prix_mini_chalet . '€ en basse saison </li>';
                    echo '<li>300€ en moyenne saison </li>';
                    echo '<li>400€ en haute saison</li>';
                    ?>
                </ul>
            </div>
            <div class="col-4 text-center">
                <h5>Descriptif:</h5>
                <ul class="text-left">
                    <li>Superficie : 25 m²</li>
                    <li>Cuisine avec micro-ondes</li>
                    <li>Télévision</li>
                    <li>chambres : 2</li>
                    <li>Salle de bain</li>
                    <li>WC</li>
                    <li>Barbecue extérieur</li>
                </ul>
            </div>
        </div>
    </div>


    <div class="container" style="border: 1px solid black" id="chalet_grand">
        <div class="row">
            <div class="col-4 align-self-start">
                <img src="./photos/bungalow_grand.jpg" alt="Bungalow 6 personnes" width="100%">
            </div>
            <div class="col-4 center-block text-center">
                <h4 class="text-center">Bungalow grand pouvant accueillir jusqu'à 6 personnes</h4>
                <ul class="text-left">
                    <?php
                    echo '<li>' . $prix_grand_chalet . '€ en basse saison </li>';
                    echo '<li>600€ en moyenne saison </li>';
                    echo '<li>800€ en haute saison</li>';
                    ?>
                </ul>
            </div>
            <div class="col-4 right-block text-center">
                <h5>Descriptif:</h5>
                <ul class="text-left">
                    <li>Superficie : 33 m²</li>
                    <li>Cuisine avec micro-ondes</li>
                    <li>Télévision</li>
                    <li>Chambres : 3</li>
                    <li>Salle de bain</li>
                    <li>WC</li>
                    <li>Barbecue extérieur</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="container" style="border: 1px solid black" id="chalet_grand_luxe">
        <div class="row">
            <div class="col-4 align-self-start">
                <img src="./photos/bungalow_grand_luxe.jpg" alt="Bungalow 6 personnes grand luxe" width="100%">
            </div>
            <div class="col-4 center-block text-center">
                <h4 class="text-center">Bungalow grand luxe pouvant accueillir jusqu'à 6 personnes</h4>
                <ul class="text-left">
                    <?php
                    echo '<li>' . $prix_grand_luxe_chalet . '€ en basse saison </li>';
                    echo '<li>900€ en moyenne saison </li>';
                    echo '<li>1200€ en haute saison</li>';
                    ?>
                </ul>
            </div>
            <div class="col-4 right-block text-center">
                <h5>Descriptif:</h5>
                <ul class="text-left">
                    <li>Superficie : 42 m²</li>
                    <li>Cuisine avec four et micro-ondes</li>
                    <li>Télévision</li>
                    <li>Chambres : 3</li>
                    <li>Salles de bain : 2</li>
                    <li>WC : 2</li>
                    <li>Barbecue extérieur</li>
                </ul>
            </div>
        </div>
    </div>

    

</body>
<?php
    include("./footer.html")
    ?>
</html>
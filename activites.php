<!DOCTYPE html>
<html lang="en">

<head>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activités</title>
    <link rel="stylesheet" href="activites.css" />
</head>

<body>
    <?php
    //test après les bug
    include("../connexion.php");
    include("./session.php");
    include("./en-tete.php");
    include("./menu.php");
?>
<div class="container-fluid" id="text">
        <h3 id="h3">Vos activités chez Camping Piscine Hashtag Plaisir</h3>
</div>

<div class="container align-self-center" style="border: 1px solid black" id="activites">
    <div class="row align-items-center" id="piscine">
        <div class="col-4">
            <img src="./photos/piscine.jpg" alt="piscine" width="100%">
        </div>
        <div class="col-8 text-center">
            <h6 class="jumbotron">Grande piscine extérieure chauffée<br>
            Parc aquatique avec ses nombreux toboggans pour tous les âges</h6>
        </div>
    </div>

    <div class="row align-items-center" id="tennis">
        <div class="col-4">
            <img src="./photos/tennis.jpg" alt="tennis" width="100%">
        </div>
        <div class="col-8 text-center">
            <h6 class="jumbotron">Terrain de tennis disponible sur réservation<br>
            Location des raquettes : 5€/heure/personne</h6>
        </div>
    </div>

    <div class="row align-items-center" id="ping_pong">
        <div class="col-4">
            <img src="./photos/ping_pong.jpg" alt="ping pong" width="100%">
        </div>
        <div class="col-8 text-center">
            <h6 class="jumbotron">5 tables de ping pong réparties dans le camping<br>
            Caution de 20€ pour les raquettes et les balles</h6>
        </div>
    </div>

    <div class="row align-items-center" id="petanque">
        <div class="col-4">
            <img src="./photos/petanque.jpg" alt="petanque" width="100%">
        </div>
        <div class="col-8 text-center">
            <h6 class="jumbotron">Grand terrain de pétanque<br>
            Caution de 10€ pour les boules</h6>
        </div>
    </div>

    <div class="row align-items-center" id="vtt">
        <div class="col-4">
            <img src="./photos/vtt.jpg" alt="vtt" width="100%">
        </div>
        <div class="col-8 text-center">
            <div class="jumbotron">
            <h6>Excurtions VTT avec guide<br>
            Prix : 40€ de l'heure avec location des vélos comprise</h6>
            <h6>Location des vélos sans guide<br>
            30€ de l'heure</h6>
            </div>
        </div>
    </div>

    

</div>


</body>
<?php
    include("./footer.html")
    ?>
</html>
<!DOCTYPE html>
<html lang="fr">

<head>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="index.css" />
</head>

<body>
    <?php
    //test après les bug
    include('./session.php');
    include("./en-tete.php");
    include("./menu.php");
    ?>
<div id="page">
    <h3 id="text_intro"> Vivez des vacances exeptionnelles au <br>Camping Piscine Hashtag Plaisir ! </h3>

    <div class="container align-self-center">
        <div class="row">
            <div class="col-2">
                
            </div>
            <div class="col-4">
                <h5 id="titre_1">Le Camping qui vous fera rêver </h5>
                <p>Avec les nombreuses activités comme le tennis, le ping pong, la pétanque, le VTT et avec notre grand parc aquatique
                    qui ravira les petits et les grands, vous passerez des vacances de rêve à la fois reposantes et amusantes.</p>
            </div>
            <div class="col-4 text-left" id="infos_pratiques">
                <h5 id="infos_pratiques"> Infos pratiques </h5>
                <p><img src="./photos/calendrier.svg" alt="calendrier" width="6%"> Ouvert du 3 mai au 26 septembre 2021</p>
                <p><img src="./photos/bungalow.svg" alt="Bungalow" width="6%"> 500 emplacements</p>
                <p><img src="./photos/localisation.svg" alt="localisation" width="6%"> 2 rue des roses <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 59430 Douai - France </p>
                <p><img src="./photos/tel.svg" alt="telephone" width="6%"> +33 06 37 ** ** **</p>
            </div>
            <div class="col-2">
                
            </div>
        </div>
    </div>
</div>


</body>
<?php
include("./footer.html");
?>

</html>
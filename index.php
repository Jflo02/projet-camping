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
    <div class="container">
            <p class="jumbotron"><a href="./chalet.php">Voir nos chalets</a></p>
            <p class="jumbotron"><a href="./promo.php">Voir nos chalets en promo !</a></p>
    </div>



</body>
<?php
include("./footer.html");
?>

</html>
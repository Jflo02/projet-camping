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


    echo '<a href="#">Voir les clients</a>';
    echo '<a href="#">Voir les Résa</a>';
    echo '<a href="#">Voir les Chalets</a>';
    echo '<a href="#">Voir les Saisons</a>';
    echo '<a href="#">Voir les semaines</a>';
    echo '<a href="#">Voir les types</a>';
    echo '<a href="./type_chalet.php">Voir les types</a>';

    ?>




</body>

</html>
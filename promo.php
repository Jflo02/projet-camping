<!DOCTYPE html>
<html lang="fr">

<head>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserver</title>
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

    //on va ragarder si des chalets ont des prix spéciaux
    $sql = 'SELECT * FROM prix_special';
    $resultat = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($resultat)) {
    }
    //coef moyenne saison
    $sql = 'SELECT * FROM saison WHERE type="moyenne"';
    $resultat = mysqli_query($conn, $sql);
    if ($resultat) {
        if (mysqli_num_rows($resultat) == 1) {
            $row = mysqli_fetch_array($resultat);
            $coef_moyenne = $row['taux'];
        }
    }

    //coef haute saison
    $sql = 'SELECT * FROM saison WHERE type="haute"';
    $resultat = mysqli_query($conn, $sql);
    if ($resultat) {
        if (mysqli_num_rows($resultat) == 1) {
            $row = mysqli_fetch_array($resultat);
            $coef_haute = $row['taux'];
        }
    }

    ?>



    <div class="container align-self-center " style="border: 1px solid black" id="chalet_mini">
        <div class="row">
            <div class="col-4 align-self-center">
                <img src="./photos/bungalow_mini.jpg" alt="Bungalow 4 personnes" width="100%">
            </div>
            <div class="col-4 ">
                <h4 class="text-center ">Bungalow mini pouvant accueillir jusqu'à 4 personnes</h4>
                <ul class="text-left ">
                    <?php
                    //prix special pr chalet mini basse saison
                    $sql = 'SELECT MIN(prix_modifie) FROM `chalet` inner join `prix_special` on `chalet`.`id_chalet` = `prix_special`.`id_chalet` inner join `semaine` on `semaine`.`id_semaine`= `prix_special`.`id_semaine` where `chalet`.`id_type_chalet` = 1 AND `semaine`.`id_saison`=1';
                    $resultat = mysqli_query($conn, $sql);
                    if ($resultat) {
                        if (mysqli_num_rows($resultat) == 1) {
                            $row = mysqli_fetch_array($resultat);
                            $prix_min = $row['MIN(prix_modifie)'];
                            if ($prix_min == NULL) {
                                echo '<li>' . ($prix_mini_chalet * 1) . '€ en basse saison </li>';
                            } else {
                                echo '<s><li>' . ($prix_mini_chalet * 1) . '€ en basse saison </li></s>';

                                echo '<div class="text-danger"><b>A partir de ' . $prix_min . '€ ! </b></div>';
                            }
                        }
                    }

                    //prix special pr chalet mini moyenne saison

                    $sql = 'SELECT MIN(prix_modifie) FROM `chalet` inner join `prix_special` on `chalet`.`id_chalet` = `prix_special`.`id_chalet` inner join `semaine` on `semaine`.`id_semaine`= `prix_special`.`id_semaine` where `chalet`.`id_type_chalet` = 1 AND `semaine`.`id_saison`=2';
                    $resultat = mysqli_query($conn, $sql);
                    if ($resultat) {
                        if (mysqli_num_rows($resultat) == 1) {
                            $row = mysqli_fetch_array($resultat);
                            $prix_min = $row['MIN(prix_modifie)'];
                            if ($prix_min == NULL) {
                                echo '<li>' . ($prix_mini_chalet * $coef_moyenne) . '€ en moyenne saison </li>';
                            } else {
                                echo '<s><li>' . ($prix_mini_chalet * $coef_moyenne) . '€ en moyenne saison </li></s>';

                                echo '<div class="text-danger"><b>A partir de ' . $prix_min . '€ ! </b></div>';
                            }
                        }
                    }

                    //prix special pr chalet mini en haute saison

                    $sql = 'SELECT MIN(prix_modifie) FROM `chalet` inner join `prix_special` on `chalet`.`id_chalet` = `prix_special`.`id_chalet` inner join `semaine` on `semaine`.`id_semaine`= `prix_special`.`id_semaine` where `chalet`.`id_type_chalet` = 1 AND `semaine`.`id_saison`=3';
                    $resultat = mysqli_query($conn, $sql);
                    if ($resultat) {
                        if (mysqli_num_rows($resultat) == 1) {
                            $row = mysqli_fetch_array($resultat);
                            $prix_min = $row['MIN(prix_modifie)'];
                            if ($prix_min == NULL) {
                                echo '<li>' . ($prix_mini_chalet * $coef_haute) . '€ en haute saison </li>';
                            } else {
                                echo '<s><li>' . ($prix_mini_chalet * $coef_haute) . '€ en haute saison </li></s>';

                                echo '<div class="text-danger"><b>A partir de ' . $prix_min . '€ ! </b></div>';
                            }
                        }
                    }
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
                <a href="./affichage_promo.php?cat=1" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Voir les offres</a>

            </div>
        </div>
    </div>


    <div class="container" style="border: 1px solid black" id="chalet_grand">
        <div class="row">
            <div class="col-4 align-self-center">
                <img src="./photos/bungalow_grand.jpg" alt="Bungalow 6 personnes" width="100%">
            </div>
            <div class="col-4 center-block text-center">
                <h4 class="text-center">Bungalow grand pouvant accueillir jusqu'à 6 personnes</h4>
                <ul class="text-left">
                    <?php

                    //prix special pr chalet grand luxe basse saison
                    $sql = 'SELECT MIN(prix_modifie) FROM `chalet` inner join `prix_special` on `chalet`.`id_chalet` = `prix_special`.`id_chalet` inner join `semaine` on `semaine`.`id_semaine`= `prix_special`.`id_semaine` where `chalet`.`id_type_chalet` = 2 AND `semaine`.`id_saison`=1';
                    $resultat = mysqli_query($conn, $sql);
                    if ($resultat) {
                        if (mysqli_num_rows($resultat) == 1) {
                            $row = mysqli_fetch_array($resultat);
                            $prix_min = $row['MIN(prix_modifie)'];
                            if ($prix_min == NULL) {
                                echo '<li>' . ($prix_grand_chalet * 1) . '€ en basse saison </li>';
                            } else {
                                echo '<s><li>' . ($prix_grand_chalet * 1) . '€ en basse saison </li></s>';

                                echo '<div class="text-danger"><b>A partir de ' . $prix_min . '€ ! </b></div>';
                            }
                        }
                    }

                    //prix special pr chalet grand luxe moyenne saison

                    $sql = 'SELECT MIN(prix_modifie) FROM `chalet` inner join `prix_special` on `chalet`.`id_chalet` = `prix_special`.`id_chalet` inner join `semaine` on `semaine`.`id_semaine`= `prix_special`.`id_semaine` where `chalet`.`id_type_chalet` = 2 AND `semaine`.`id_saison`=2';
                    $resultat = mysqli_query($conn, $sql);
                    if ($resultat) {
                        if (mysqli_num_rows($resultat) == 1) {
                            $row = mysqli_fetch_array($resultat);
                            $prix_min = $row['MIN(prix_modifie)'];
                            if ($prix_min == NULL) {
                                echo '<li>' . ($prix_grand_chalet * $coef_moyenne) . '€ en moyenne saison </li>';
                            } else {
                                echo '<s><li>' . ($prix_grand_chalet * $coef_moyenne) . '€ en moyenne saison </li></s>';

                                echo '<div class="text-danger"><b>A partir de ' . $prix_min . '€ ! </b></div>';
                            }
                        }
                    }

                    //prix special pr chalet grand luxe en haute saison

                    $sql = 'SELECT MIN(prix_modifie) FROM `chalet` inner join `prix_special` on `chalet`.`id_chalet` = `prix_special`.`id_chalet` inner join `semaine` on `semaine`.`id_semaine`= `prix_special`.`id_semaine` where `chalet`.`id_type_chalet` = 2 AND `semaine`.`id_saison`=3';
                    $resultat = mysqli_query($conn, $sql);
                    if ($resultat) {
                        if (mysqli_num_rows($resultat) == 1) {
                            $row = mysqli_fetch_array($resultat);
                            $prix_min = $row['MIN(prix_modifie)'];
                            if ($prix_min == NULL) {
                                echo '<li>' . ($prix_grand_chalet * $coef_haute) . '€ en haute saison </li>';
                            } else {
                                echo '<s><li>' . ($prix_grand_chalet * $coef_haute) . '€ en haute saison </li></s>';

                                echo '<div class="text-danger"><b>A partir de ' . $prix_min . '€ ! </b></div>';
                            }
                        }
                    }

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
                <a href="./affichage_promo.php?cat=2" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Voir les offres</a>

            </div>
        </div>
    </div>

    <div class="container" style="border: 1px solid black" id="chalet_grand_luxe">
        <div class="row">
            <div class="col-4 align-self-center">
                <img src="./photos/bungalow_grand_luxe.jpg" alt="Bungalow 6 personnes grand luxe" width="100%">
            </div>
            <div class="col-4 center-block text-center">
                <h4 class="text-center">Bungalow grand luxe pouvant accueillir jusqu'à 6 personnes</h4>
                <ul class="text-left">
                    <?php

                    //prix special pr chalet grand luxe basse saison
                    $sql = 'SELECT MIN(prix_modifie) FROM `chalet` inner join `prix_special` on `chalet`.`id_chalet` = `prix_special`.`id_chalet` inner join `semaine` on `semaine`.`id_semaine`= `prix_special`.`id_semaine` where `chalet`.`id_type_chalet` = 3 AND `semaine`.`id_saison`=1';
                    $resultat = mysqli_query($conn, $sql);
                    if ($resultat) {
                        if (mysqli_num_rows($resultat) == 1) {
                            $row = mysqli_fetch_array($resultat);
                            $prix_min = $row['MIN(prix_modifie)'];
                            if ($prix_min == NULL) {
                                echo '<li>' . ($prix_grand_luxe_chalet * 1) . '€ en basse saison </li>';
                            } else {
                                echo '<s><li>' . ($prix_grand_luxe_chalet * 1) . '€ en basse saison </li></s>';

                                echo '<div class="text-danger"><b>A partir de ' . $prix_min . '€ ! </b></div>';
                            }
                        }
                    }

                    //prix special pr chalet grand luxe moyenne saison

                    $sql = 'SELECT MIN(prix_modifie) FROM `chalet` inner join `prix_special` on `chalet`.`id_chalet` = `prix_special`.`id_chalet` inner join `semaine` on `semaine`.`id_semaine`= `prix_special`.`id_semaine` where `chalet`.`id_type_chalet` = 3 AND `semaine`.`id_saison`=2';
                    $resultat = mysqli_query($conn, $sql);
                    if ($resultat) {
                        if (mysqli_num_rows($resultat) == 1) {
                            $row = mysqli_fetch_array($resultat);
                            $prix_min = $row['MIN(prix_modifie)'];
                            if ($prix_min == NULL) {
                                echo '<li>' . ($prix_grand_luxe_chalet * $coef_moyenne) . '€ en moyenne saison </li>';
                            } else {
                                echo '<s><li>' . ($prix_grand_luxe_chalet * $coef_moyenne) . '€ en moyenne saison </li></s>';

                                echo '<div class="text-danger"><b>A partir de ' . $prix_min . '€ ! </b></div>';
                            }
                        }
                    }

                    //prix special pr chalet grand luxe en haute saison

                    $sql = 'SELECT MIN(prix_modifie) FROM `chalet` inner join `prix_special` on `chalet`.`id_chalet` = `prix_special`.`id_chalet` inner join `semaine` on `semaine`.`id_semaine`= `prix_special`.`id_semaine` where `chalet`.`id_type_chalet` = 3 AND `semaine`.`id_saison`=3';
                    $resultat = mysqli_query($conn, $sql);
                    if ($resultat) {
                        if (mysqli_num_rows($resultat) == 1) {
                            $row = mysqli_fetch_array($resultat);
                            $prix_min = $row['MIN(prix_modifie)'];
                            if ($prix_min == NULL) {
                                echo '<li>' . ($prix_grand_luxe_chalet * $coef_haute) . '€ en haute saison </li>';
                            } else {
                                echo '<s><li>' . ($prix_grand_luxe_chalet * $coef_haute) . '€ en haute saison </li></s>';

                                echo '<div class="text-danger"><b>A partir de ' . $prix_min . '€ ! </b></div>';
                            }
                        }
                    }


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
                <a href="./affichage_promo.php?cat=3" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Voir les offres</a>

            </div>
        </div>
    </div>



</body>
<?php
include("./footer.html")
?>

</html>
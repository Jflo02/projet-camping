<?php
include('./session.php');
$erreur_login = FALSE;

if (isset($_POST['mdp_user'])) {
    //ici on se connecte a la base sql
    include("../connexion.php");


    $sql = 'SELECT * from Client where mail=\'' . mysqli_real_escape_string($conn, $_POST["mail_user"]) . '\' and mdp_client=\'' . mysqli_real_escape_string($conn, $_POST["mdp_user"]) . '\'';


    $resultat = mysqli_query($conn, $sql);

    if ($resultat == FALSE) {
        die("<br>Echec d'execution de la requete : " . $sql);
    } else {
        if (mysqli_num_rows($resultat) == 1) {

            $row = mysqli_fetch_array($resultat);
            $_SESSION['id_user'] = $row['id_client'];
            $_SESSION['nom_user'] = $row['nom'];
            $_SESSION['prenom_user'] = $row['prenom'];
            $_SESSION['mail'] = $row['mail'];
            $_SESSION['type'] = "client";

            $url = $_SERVER['HTTP_REFERER'];
            $tableau = explode("/", $url, -1);
            $location = "";
            foreach ($tableau as $valeur) {
                $location = $location . $valeur . "/";
            }
            $location = $location . 'index.php';
            header("Location: $location");
            exit();
        } else {

            $sql = 'SELECT * from administrateur where login_administrateur=\'' . mysqli_real_escape_string($conn, $_POST["mail_user"]) . '\' and mdp_administrateur=\'' . mysqli_real_escape_string($conn, $_POST["mdp_user"]) . '\'';


            $resultat = mysqli_query($conn, $sql);
            if ($resultat == FALSE) {
                die("<br>Echec d'execution de la requete : " . $sql);
            } else {
                if (mysqli_num_rows($resultat) == 1) {

                    $row = mysqli_fetch_array($resultat);
                    $_SESSION['id_user'] = $row['id'];
                    $_SESSION['nom_user'] = $row['login_administrateur'];
                    $_SESSION['prenom_user'] = $row['login_administrateur'];
                    $_SESSION['type'] = "admin";

                    $url = $_SERVER['HTTP_REFERER'];
                    $tableau = explode("/", $url, -1);
                    $location = "";
                    foreach ($tableau as $valeur) {
                        $location = $location . $valeur . "/";
                    }
                    $location = $location . 'index.php';
                    header("Location: $location");
                    exit();
                } else {


                    $erreur_login = TRUE;
                }
            }
        }
    }
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="Expires" content="0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css" />
</head>

<body>


    <?php
    //on met l'en-tete
    include("./en-tete.php");
    //include("./menu.php");



    ?>
    <div class="container">
        <div class="row">
            <div class="col">

                <?php




                if (!isset($_SESSION['id_user'])) {
                ?>

                    <div class="container">
                        <div class=" text-center mt-5 ">
                            <h1>Connexion</h1>
                        </div>
                        <div class="row ">
                            <div class="col-lg-7 mx-auto">
                                <div class="card mt-2 mx-auto p-4 bg-light">
                                    <div class="card-body bg-light">
                                        <div class="container">
                                            <form id="contact-form" role="form" action="./login.php" method="post">
                                                <div class="controls">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group"> <label for="mail_user">Mail</label> <input id="mail_user" type="text" name="mail_user" class="form-control" placeholder="Entrez votre mail" required="required" data-error="Entrez votre mail."> </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group"> <label for="mdp_user">Mot de passe</label> <input id="mdp_user" type="password" name="mdp_user" class="form-control" placeholder="Entrez votre mot de passe" required="required" data-error="Entrez votre mot de passe."> </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-12"> <input type="submit" class="btn btn-success btn-send pt-2 btn-block " value="Se connecter"> </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>





                <?php



                }


                if ($erreur_login) {
                    echo '<br><br><div class="container jumbotron"><h3><p class="text-danger"><b>Identifiant ou mot de passe incorrect</b></p></h3></div>';
                }

                ?>
            </div>
        </div>
    </div>
</body>

</html>
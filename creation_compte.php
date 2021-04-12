<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Expires" content="0">
    <link rel="stylesheet" href="styles.css" />
</head>

<body>
    <?php
    include("../connexion.php");

    //on met l'en-tete
    include("./en-tete.php");
    include("./menu.php");




    if (!isset($_GET['c'])) {
        die();
    }

    switch ($_GET['c']) {

        case 'add':
            foreach ($_GET as $key => $Value) {
                if (empty($Value)) {
                    die("Il manque une valeur pour " . $key);
                }
            }



            $sql = "INSERT INTO client (nom, prenom, date_Naissance, mail, telephone, adresse, cp_ville, mdp_client, ville ) values
            ('" . $_GET['nom_pers'] . "','" . $_GET['prenom_pers'] . "','" . $_GET['DN_pers'] . "','" . $_GET['mail_pers'] . "','" . $_GET['tel_pers'] . "','" . $_GET['adresse_pers'] . "','" . $_GET['cp_pers'] . "','" . $_GET['mdp_pers'] . "','" . $_GET['ville_pers'] . "')";
            $resultat = mysqli_query($conn, $sql);
            if ($resultat == FALSE) { //si on peut pas ajouter

                die("<br>Echec d'execution de la requete : ");
            } else {
                echo "Votre compte a été créé, vous pouvez maintenant vous connecter";
            }


            break;



        default: //créer un compte si on est client lambda
    ?>

            <div class="container">
                <div class=" text-center mt-5 ">
                    <h1>Inscription</h1>
                </div>
                <div class="row ">
                    <div class="col-lg-7 mx-auto">
                        <div class="card mt-2 mx-auto p-4 bg-light">
                            <div class="card-body bg-light">
                                <div class="container">
                                    <form id="contact-form" role="form" action="./creation_compte.php" method="get">
                                        <div class="controls">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group"> <label for="prenom_pers">Prénom</label> <input id="prenom_pers" type="text" name="prenom_pers" class="form-control" placeholder="Entrez votre prénom" required="required" data-error="Entrez votre prénom."> </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group"> <label for="nom_pers">Nom</label> <input id="nom_pers" type="text" name="nom_pers" class="form-control" placeholder="Entrez votre nom de famille" required="required" data-error="Entrez votre nom de famille."> </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group"> <label for="mail_pers">Email</label> <input id="mail_pers" type="email" name="mail_pers" class="form-control" placeholder="Entrez votre email" required="required" data-error="Entrez un email valide."> </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group"> <label for="DN_pers">Date De Naissance</label> <input id="DN_pers" type="date" name="DN_pers" class="form-control" placeholder="Date de naissance" required="required" data-error="Entrez une date de naissance."> </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group"> <label for="mdp_pers">Mot de passe</label> <input id="mdp_pers" type="password" name="mdp_pers" class="form-control" placeholder="Entrez votre mot de passe" required="required" data-error="Entrez votre mot de passe" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"> </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group"> <label for="tel_pers">Telephone</label> <input id="tel_pers" type="text" name="tel_pers" class="form-control" placeholder="Entrez votre telephone" required="required" data-error="Entrez votre telephone"> </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group"> <label for="cp_pers">Code Postal</label> <input id="cp_pers" type="text" name="cp_pers" class="form-control" placeholder="Entrez votre code postal" required="required" data-error="Entrez votre code postal"> </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group"> <label for="adresse_pers">Adresse</label> <input id="adresse_pers" type="text" name="adresse_pers" class="form-control" placeholder="Entrez votre adresse" required="required" data-error="Entrez votre adresse"> </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group"> <label for="ville_pers">Ville</label> <input id="ville_pers" type="text" name="ville_pers" class="form-control" placeholder="Entrez votre ville" required="required" data-error="Entrez votre ville"> </div>
                                                </div>

                                            </div>



                                            <div class="row">
                                                <input type="hidden" name="c" value="add">
                                                <div class="col-md-12"> <input type="submit" class="btn btn-success btn-send pt-2 btn-block " value="S'inscrire"> </div>
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
            break;
    }
    ?>


</body>
<br><br>
<?php
include("./footer.html");
?>

</html>
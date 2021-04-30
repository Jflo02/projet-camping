<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <meta charset="utf-8" />
    <title>Circuits</title>
    <link rel="stylesheet" href="index.css" />

</head>

<body>

    <?php
    include('./session.php');
    include("./en-tete.php");
    include("./menu.php");
    include("../connexion.php");





    ?>
    <div class="container">

        <?php

        switch ($_GET['c']) {
            case 'modif':
                foreach ($_GET as $key => $Value) {
                    if (empty($Value)) {
                        die("Il manque une valeur pour " . $key);
                    }
                }
                $sql = "UPDATE client SET nom='" . mysqli_real_escape_string($conn,$_GET['nom_pers']) . "', prenom='" . mysqli_real_escape_string($conn,$_GET['prenom_pers']) . "',date_naissance='" . mysqli_real_escape_string($conn,$_GET['DN_pers']) . "',mail='" . mysqli_real_escape_string($conn,$_GET['mail_pers']) . "', telephone='" . mysqli_real_escape_string($conn,$_GET['tel_pers']) . "', adresse='" . mysqli_real_escape_string($conn,$_GET['adresse_pers']) . "', cp_ville='" . mysqli_real_escape_string($conn,$_GET['cp_pers']) . "' , mdp_client='" . mysqli_real_escape_string($conn,$_GET['mdp_pers']) . "', ville='" . mysqli_real_escape_string($conn,$_GET['ville_pers']) . "' where id_client=" . $_GET['id_client'];
                $stmt = mysqli_query($conn, $sql);
                if ($stmt == FALSE) {
                    die("<br>Echec d'execution de la requete : " . $sql);
                } else {
                    echo "Enregistrement mis à jour<br><br>";
                    echo '<a href="./mon_compte.php?c=default">Retour à mon compte</a>';
                }
                break;

            default:
            echo '<a href="./reservations.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Voir mes réservations</a>';
                
                echo "<br><br>";
                $sql = "SELECT * FROM client WHERE id_client=" . $_SESSION['id_user'];
                $stmt = mysqli_query($conn, $sql);
                if ($stmt == FALSE) {
                    die("<br>Echec d'execution de la requete : " . $sql);
                } else {

                    while ($row = mysqli_fetch_array($stmt)) {
                        $str_date = $row['date_naissance'];
        ?>


            <div class="container">
                <div class=" text-center mt-5 ">
                    <h1>Mon compte</h1>
                </div>
                <div class="row ">
                    <div class="col-lg-7 mx-auto">
                        <div class="card mt-2 mx-auto p-4 bg-light">
                            <div class="card-body bg-light">
                                <div class="container">
                                    <form id="contact-form" role="form" action="./mon_compte.php" method="get">
                                        <div class="controls">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group"> 
                                                    <label for="prenom_pers">Prénom</label> 
                                                    <input id="prenom_pers" type="text" name="prenom_pers" value="<?php echo $row['prenom'] ?>" class="form-control" placeholder="Entrez votre prénom" required="required" data-error="Entrez votre prénom."> </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group"> <label for="nom_pers">Nom</label> 
                                                    <input id="nom_pers" type="text" name="nom_pers" value="<?php echo $row['nom'] ?>" class="form-control" placeholder="Entrez votre nom de famille" required="required" data-error="Entrez votre nom de famille."> </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group"> <label for="mail_pers">Email</label> 
                                                    <input id="mail_pers" type="email" name="mail_pers" value="<?php echo $row['mail'] ?>" class="form-control" placeholder="Entrez votre email" required="required" data-error="Entrez un email valide."> </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group"> <label for="DN_pers">Date De Naissance</label> 
                                                    <input id="DN_pers" type="date" name="DN_pers" value="<?php echo $row['date_naissance'] ?>" class="form-control" placeholder="Date de naissance" required="required" data-error="Entrez une date de naissance."> </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group"> <label for="mdp_pers">Mot de passe</label> 
                                                    <input id="mdp_pers" type="password" name="mdp_pers" value="<?php echo $row['mdp_client'] ?>" class="form-control" placeholder="Entrez votre mot de passe" required="required" data-error="Entrez votre mot de passe" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"> </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group"> <label for="tel_pers">Telephone</label> 
                                                    <input id="tel_pers" type="text" name="tel_pers" value="<?php echo $row['telephone'] ?>" class="form-control" placeholder="Entrez votre telephone" required="required" data-error="Entrez votre telephone"> </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group"> <label for="cp_pers">Code Postal</label> 
                                                    <input id="cp_pers" type="text" name="cp_pers" value="<?php echo $row['cp_ville'] ?>" class="form-control" placeholder="Entrez votre code postal" required="required" data-error="Entrez votre code postal"> </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group"> <label for="adresse_pers">Adresse</label> 
                                                    <input id="adresse_pers" type="text" name="adresse_pers" value="<?php echo $row['adresse'] ?>" class="form-control" placeholder="Entrez votre adresse" required="required" data-error="Entrez votre adresse"> </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group"> <label for="ville_pers">Ville</label> 
                                                    <input id="ville_pers" type="text" name="ville_pers" value="<?php echo $row['ville'] ?>" class="form-control" placeholder="Entrez votre ville" required="required" data-error="Entrez votre ville"> </div>
                                                </div>

                                            </div>



                                            <div class="row">
                                                <input type="hidden" name="c" value="modif">
                                                <input type="hidden" name="id_client" value="<?php echo $row['id_client'] ?>">
                                                <div class="col-md-12"> <input type="submit" class="btn btn-success btn-send pt-2 btn-block " value="Modifier"> </div>
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
                }
        }

        ?>


    </div>
    <!--On ferme le div du corps -->
</body>
<?php
include("./footer.html");
?>

</html>
<!DOCTYPE html>
<html lang="fr">

<head>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client admin</title>
    <link rel="stylesheet" href="index.css" />
</head>

<body>

    <?php
    include('./session.php');
    include("./en-tete.php");
    //ici on se connecte a la base sql
    include("../connexion.php");
    include("./menu.php");


    switch ($_GET['c']) {


        case 'create':
    ?>


            <div class="container">
                <div class=" text-center mt-5 ">
                    <h1>Fiche Client</h1>
                </div>
                <div class="row ">
                    <div class="col-lg-7 mx-auto">
                        <div class="card mt-2 mx-auto p-4 bg-light">
                            <div class="card-body bg-light">
                                <div class="container">
                                    <form id="contact-form" role="form" action="./client_admin.php" method="get">
                                        <div class="controls">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group"> <label for="prenom_pers">Prénom</label> <input id="prenom_pers" type="text" name="prenom_pers" class="form-control" placeholder="Entrez le prénom" required="required" data-error="Entrez le prénom."> </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group"> <label for="nom_pers">Nom</label> <input id="nom_pers" type="text" name="nom_pers" class="form-control" placeholder="Entrez le nom de famille" required="required" data-error="Entrez le nom de famille."> </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group"> <label for="mail_pers">Email</label> <input id="mail_pers" type="email" name="mail_pers" class="form-control" placeholder="Entrez l'email" required="required" data-error="Entrez un email valide."> </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group"> <label for="DN_pers">Date De Naissance</label> <input id="DN_pers" type="date" name="DN_pers" class="form-control" placeholder="Date de naissance" required="required" data-error="Entrez une date de naissance."> </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group"> <label for="cp_pers">Code Postal</label> <input id="cp_pers" type="text" name="cp_pers" class="form-control" placeholder="Entrez le code postal" required="required" data-error="Entrez le code postal"> </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group"> <label for="adresse_pers">Adresse</label> <input id="adresse_pers" type="text" name="adresse_pers" class="form-control" placeholder="Entrez l'adresse" required="required" data-error="Entrez l'adresse"> </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group"> <label for="ville_pers">Ville</label> <input id="ville_pers" type="text" name="ville_pers" class="form-control" placeholder="Entrez la ville" required="required" data-error="Entrez la ville"> </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group"> <label for="tel_pers">Telephone</label> <input id="tel_pers" type="text" name="tel_pers" class="form-control" placeholder="Entrez le telephone" required="required" data-error="Entrez le telephone"> </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group"> <label for="mdp_pers">Mot de passe</label> <input id="mdp_pers" type="password" name="mdp_pers" class="form-control" placeholder="Entrez le mot de passe" required="required" data-error="Entrez le mot de passe" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"> </div>
                                                </div>
                                            </div>



                                            <div class="row">
                                                <input type="hidden" name="c" value="add">
                                                <div class="col-md-12"> <input type="submit" class="btn btn-success btn-send pt-2 btn-block " value="Envoyer"> </div>
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

        case 'add':

            $sql = "INSERT INTO client (nom, prenom, date_naissance, mail, telephone, adresse, cp_ville, mdp_client, ville) values ('" . mysqli_real_escape_string($conn, $_GET['nom_pers']) . "','" . mysqli_real_escape_string($conn, $_GET['prenom_pers']) . "','" . mysqli_real_escape_string($conn, $_GET['DN_pers']) . "','" . mysqli_real_escape_string($conn, $_GET['mail_pers']) . "','" . mysqli_real_escape_string($conn, $_GET['tel_pers']) . "','" . mysqli_real_escape_string($conn, $_GET['adresse_pers']) . "','" . mysqli_real_escape_string($conn, $_GET['cp_pers']) . "','" . mysqli_real_escape_string($conn, $_GET['mdp_pers']) . "','" . mysqli_real_escape_string($conn, $_GET['ville_pers']) . "')";
            $resultat = mysqli_query($conn, $sql);
            if ($resultat == FALSE) {
                die("<br>Echec d'execution de la requete : " . $sql);
            } else {
                echo "Ajout OK !";
                echo "Enregistrement mis à jour<br><br>";
                echo '<a href="./client_admin.php?c=default">Retour aux clients</a>';
            }
            break;

        case 'read':

            $sql = "SELECT * FROM client WHERE id_client=" . $_GET['id_client'];
            $resultat = mysqli_query($conn, $sql);
            if ($resultat == FALSE) {
                die("<br>Echec d'execution de la requete : " . $sql);
            } elseif (mysqli_num_rows($resultat) == 1) {
                $row = mysqli_fetch_assoc($resultat);
            ?>
                <div class="container">
                    <div class=" text-center mt-5 ">
                        <h1>Fiche Client</h1>
                    </div>
                    <div class="row ">
                        <div class="col-lg-7 mx-auto">
                            <div class="card mt-2 mx-auto p-4 bg-light">
                                <div class="card-body bg-light">
                                    <div class="container">
                                        <form id="contact-form" role="form" action="./client_admin.php" method="get">
                                            <div class="controls">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group"> <label for="prenom_pers">Prénom</label> <input id="prenom_pers" type="text" name="prenom_pers" class="form-control" placeholder="Entrez votre prénom" required="required" data-error="Entrez votre prénom." value="<?php echo $row['prenom'] ?>"> </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group"> <label for="nom_pers">Nom</label> <input id="nom_pers" type="text" name="nom_pers" class="form-control" placeholder="Entrez votre nom de famille" required="required" data-error="Entrez votre nom de famille." value="<?php echo $row['nom'] ?>"> </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group"> <label for="mail_pers">Email</label> <input id="mail_pers" type="email" name="mail_pers" class="form-control" placeholder="Entrez votre email" required="required" data-error="Entrez un email valide." value="<?php echo $row['mail'] ?>"> </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group"> <label for="DN_pers">Date De Naissance</label> <input id="DN_pers" type="date" name="DN_pers" class="form-control" placeholder="Date de naissance" required="required" data-error="Entrez une date de naissance." value="<?php echo $row['date_naissance'] ?>"> </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group"> <label for="cp_pers">Code Postal</label> <input id="cp_pers" type="text" name="cp_pers" class="form-control" placeholder="Entrez votre code postal" required="required" data-error="Entrez votre code postal" value="<?php echo $row['cp_ville'] ?>"> </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group"> <label for="adresse_pers">Adresse</label> <input id="adresse_pers" type="text" name="adresse_pers" class="form-control" placeholder="Entrez votre adresse" required="required" data-error="Entrez votre adresse" value="<?php echo $row['adresse'] ?>"> </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group"> <label for="ville_pers">Ville</label> <input id="ville_pers" type="text" name="ville_pers" class="form-control" placeholder="Entrez votre ville" required="required" data-error="Entrez votre ville" value="<?php echo $row['ville'] ?>"> </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group"> <label for="tel_pers">Telephone</label> <input id="tel_pers" type="text" name="tel_pers" class="form-control" placeholder="Entrez votre telephone" required="required" data-error="Entrez votre telephone" value="<?php echo $row['telephone'] ?>"> </div>
                                                    </div>
                                                </div>



                                                <div class="row">
                                                    <input type="hidden" name="id_client" value="<?php echo $row['id_client'] ?>">
                                                    <input type="hidden" name="c" value="update">
                                                    <div class="col-md-12"> <input type="submit" class="btn btn-success btn-send pt-2 btn-block " value="Envoyer"> </div>
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
            break;

        case 'update':

            $sql = "UPDATE client SET nom='" . $_GET['nom_pers'] . "', prenom='" . $_GET['prenom_pers'] . "',date_naissance='" . $_GET['DN_pers'] . "',mail='" . $_GET['mail_pers'] . "', telephone='" . $_GET['tel_pers'] . "', adresse='" . $_GET['adresse_pers'] . "', cp_ville='" . $_GET['cp_pers'] . "', ville='" . $_GET['ville_pers'] . "' where id_client=" . $_GET['id_client'];
            $stmt = mysqli_query($conn, $sql);
            if ($stmt == FALSE) {
                die("<br>Echec d'execution de la requete : " . $sql);
            } else {
                echo "Enregistrement mis à jour<br><br>";
                echo '<a href="./client_admin.php?c=default">Retour aux clients</a>';
            }
            break;

        case 'del':
            $sql = "DELETE FROM client where id_client='" . $_GET['id_client'] . "'";
            $resultat = mysqli_query($conn, $sql);
            if ($resultat == FALSE) {
                die("<br>Echec d'execution de la requete : " . $sql);
            } else {
                echo "Enregistrement supprimé";
            }
            break;



        default: //liste les enregistrements

            $sql = 'SELECT * FROM client';
            $resultat = mysqli_query($conn, $sql);
            if ($resultat == FALSE) {
                die("<br>Echec d'execution de la requete : " . $sql);
            } else {

            ?>
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col align-self-center">
                            <p>Liste des clients</p>
                            <p><br><a href='./client_admin.php?c=create'>Ajouter</a></p>

                            <table class="table table-striped">
                                <tr>
                                    <td>nom</td>
                                    <td>prenom</td>
                                    <td>date_naissance</td>
                                    <td>mail</td>
                                    <td>téléphne</td>
                                    <td>adresse</td>
                                    <td>code postale</td>
                                    <td>Ville</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            <?php
                            while ($row = mysqli_fetch_assoc($resultat)) {
                                echo "<tr>";
                                echo "<td>" . $row['nom'] . "</td>";
                                echo "<td>" . $row['prenom'] . "</td>";
                                echo "<td>" . $row['date_naissance'] . "</td>";
                                echo "<td>" . $row['mail'] . "</td>";
                                echo "<td>" . $row['telephone'] . "</td>";
                                echo "<td>" . $row['adresse'] . "</td>";
                                echo "<td>" . $row['cp_ville'] . "</td>";
                                echo "<td>" . $row['ville'] . "</td>";

                                echo "<td><a href=./client_admin.php?c=del&id_client=" . $row['id_client'] . ">supprimer</a></td>";
                                echo "<td><a href=./client_admin.php?c=read&id_client=" . $row['id_client'] . ">éditer</a></td>";
                            }
                            echo "</tr>";
                        }
                        echo "</table>";
                            ?>

                        </div>
                    </div>
                </div>


        <?php

            break;
    }

        ?>



</body>
<?php
include("./footer.html");
?>

</html>
<?php 

$erreur_login=FALSE;

if (isset($_POST['mdp_user'])) {
    //ici on se connecte a la base sql
    include("../connexion.php");

    


    $sql = 'SELECT * from Client where mail=\'' . $_POST["mail_user"] . '\' and mdp_client=\'' . $_POST["mdp_user"] . '\'';
    //$sql = 'SELECT * from Client' ;

    $resultat = mysqli_query($conn, $sql);

    if ($resultat == FALSE) {
        die("<br>Echec d'execution de la requete : " . $sql);
    } else {
        if (mysqli_num_rows($resultat) == 1) {

            $row = mysqli_fetch_array($resultat);
            $_SESSION['id_user'] = $row['id_client'];
            $_SESSION['nom_user'] = $row['nom'];
            $_SESSION['prenom_user'] = $row['prenom'];
            $_SESSION['type'] = "client";


            $backslash = chr(92);
            $login_position=getcwd();
            $tableau = explode ($backslash , $login_position );
            $location = 'http://localhost' ;
            foreach ($tableau as $cle => $valeur){
                if ($cle < 3) continue;
                    $location=$location.'/'. $valeur;
            }
            $location=$location . '/index.php';
            
            header("Location: $location");
            exit();
        
            }else{
                $erreur_login=TRUE;
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

                if ($erreur_login){
                    echo 'Identifiant ou mot de passe incorrecte' ;
                }

               






                if (isset($_SESSION['type'])) {

                    echo 'Hello ' . (($_SESSION['type'] == "Administrateur") ? "Administrateur " : "client ") . $_SESSION['nom_user'] . ' ' . $_SESSION['prenom_user'];
                    echo '<br><a href="./login.php?logout=1">Se deconnecter</a><br><br>';
                    echo '<br><a href="./">Aller à l\'acceuil</a><br><br>';
                }


                if (!isset($_SESSION['id_user'])) {
                ?>
                    <form action="./login.php" method="post">
                        <label for="nom">Mail :</label>
                        <input type="text" id="mail_user" name="mail_user"><br><br>
                        <label for="password">Mot de passe :</label>
                        <input type="password" id="mdp_user" name="mdp_user"><br><br>
                        <input type="submit" value="Envoyer">

                    </form>

                <?php
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>
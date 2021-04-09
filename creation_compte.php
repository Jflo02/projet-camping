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
    //include("./menu.php");




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
            <form action="./creation_compte.php" method="get">
                <label for="nom">Nom:</label>
                <input type="text" id="nom_pers" name="nom_pers" required="required"><br><br>

                <label for="prenom">Prenom:</label>
                <input type="text" id="prenom_pers" name="prenom_pers" required="required"><br><br>

                <label for="Date_Naissance">Date de naissance:</label>
                <input type="date" id="DN_pers" name="DN_pers" required="required"><br><br>

                <label for="password">Mot de passe :</label>
                <input type="password" id="mdp_pers" name="mdp_pers" minlength="8" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"><br><br>
                <p>8 caractères d'au moins un chiffre et une lettre majuscule et minuscule</p>

                <label for="Personne_Mail">Mail:</label>
                <input type="text" id="mail_pers" name="mail_pers" required="required"><br><br>

                <label for="Personne_tel">Telephone:</label>
                <input type="text" id="tel_pers" name="tel_pers" required="required"><br><br>

                <label for="Personne_cp">Code postal:</label>
                <input type="text" id="cp_pers" name="cp_pers" required="required"><br><br>

                <label for="Personne_Mail">Ville:</label>
                <input type="text" id="ville_pers" name="ville_pers" required="required"><br><br>

                <label for="Personne_adresse">Adresse:</label>
                <input type="text" id="adresse_pers" name="adresse_pers" required="required"><br><br>



                <input type="hidden" name="c" value="add">
                <input type="submit" value="Envoyer">
            </form>
    <?php
            break;
    }
    ?>


</body>

</html>
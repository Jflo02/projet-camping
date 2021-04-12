<?php
    //ici on se connecte a la base sql
    include("../connexion.php");
    include('./session.php');
    $jour="";
    $requete=FALSE;
    if (isset($_GET['date'])){
        $d = new DateTime ($_GET['date']);
        $jour = $d -> format ('D');
        //on lance la requete si le jour est bien un samedi
        if ($jour=="Sat"){
            //FAIRE LA VERIF ET LA REQUETE
            $sql = "SELECT * FROM semaine";
            $resultat = mysqli_query($conn, $sql);
            if ($resultat == FALSE) {
                die("<br>Echec d'execution de la requete : " . $sql);
            } else {
                foreach (range (1, $_GET['nbr_jour']) as $number){
                    //vérifier date in array
                }
            }
        }
    }
?>

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
    
    

    if (!isset($_GET['date'])){
    ?>
        <!-- Formulaire pour demander la date du premier samedi à partir du quel remplir les semaines -->
            <form action="" method="get">
                <label for="date">Entrez la date du premier samedi à partir duquel vous souhaitez initialiser les semaines :</label>
                <input type="date" id="date" name="date" value="<?php echo date('Y-m-d')?>"><br><br>
                <label for="nbr_jour">Combien de semaines ?:</label>
                <input type="number" id="nbr_jour" name="nbr_jour" min=1 required><br><br>
                <input type="submit" value="Envoyer">
            </form>
    <?php
    }elseif($jour!="Sat"){
        echo "Veuillez entrer un samedi.<br>";
        ?>
        <!-- Formulaire pour demander la date du premier samedi à partir du quel remplir les semaines -->
        <form action="" method="get">
            <label for="date">Entrez la date du premier samedi à partir duquel vous souhaitez initialiser les semaines :</label>
            <input type="date" id="date" name="date" value="<?php echo date('Y-m-d')?>"><br><br>
            <label for="nbr_jour">Combien de semaines ?:</label>
            <input type="number" id="nbr_jour" name="nbr_jour" min=1 required><br><br>            
            <input type="submit" value="Envoyer">
        </form>
    <?php
    }elseif($requete==TRUE){

    }
    ?>
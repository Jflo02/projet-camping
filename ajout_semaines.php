<?php
    //ici on se connecte a la base sql
    include("../connexion.php");
    include('./session.php');
    $jour="";
    $requete=FALSE;
    $semaine_dans_base=FALSE;
    //on vérifie si la variable est deja set
    if (isset($_GET['date'])){
        $date = new DateTime ($_GET['date']);
        $jour = $date -> format ('D');
        //on lance la requete si le jour est bien un samedi
        if ($jour=="Sat"){
            //FAIRE LA VERIF ET LA REQUETE
            $sql = "SELECT * FROM semaine";
            $resultat = mysqli_query($conn, $sql);
            if ($resultat == FALSE) {
                die("<br>Echec d'execution de la requete : " . $sql);
            } else {
                //on crée un tableau des dates de début
                while ($row = mysqli_fetch_assoc($resultat)) {
                    $array_debut[]=$row['date_debut'];
                    $array_id[]=$row['id_semaine'];
                }
                $max_id = max($array_id);//on calcul le max id pour la requete apres
                $interval= new DateInterval("P7D");
                //on retire une semaine pour que la premiere semaine soit bien celle choisi par l'user
                $date_minus = date_sub($date, $interval);
                foreach (range (1, $_GET['nbr_jour']) as $number){
                    //on vérifie si aucune date n'est deja dans la base                 
                    $d = date_add($date_minus, $interval);
                    $date_string = $d-> format ('Y-m-d');
                    if (in_array($date_string, $array_debut)){
                        $semaine_deja_enregistre[]= $date_string;
                        $semaine_dans_base=TRUE;
                    }else{
                        $semaine_a_ajouter[]=$date_string;
                    }
                }
            
            }

    }
        
        //on ajoute les semaines a ajouter une par une
        if(isset($semaine_a_ajouter)){
            foreach($semaine_a_ajouter as $date_debut){
                $max_id = $max_id + 1 ;
                $sql_insert = "INSERT INTO `semaine` VALUES (" . $max_id . ", '" . $date_debut . "'," . $_GET['saison'] . ")" ;
                $resultat_insert = mysqli_query($conn, $sql_insert) ;
                $requete=TRUE;
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
    include("./menu.php");
    
    

    if (!isset($_GET['date'])){
    ?>
        <!-- Formulaire pour demander la date du premier samedi à partir du quel remplir les semaines -->
            <form action="" method="get">
                <label for="date">Entrez la date du premier samedi à partir duquel vous souhaitez initialiser les semaines :</label>
                <input type="date" id="date" name="date" value="<?php echo date('Y-m-d')?>"><br><br>
                <label for="nbr_jour">Combien de semaines ?:</label>
                <input type="number" id="nbr_jour" name="nbr_jour" min=1 required><br><br>
                <label for="pet-select">Quelle saison:</label>
                <select name="saison" id="saison">
                    <option value="1">Basse</option>
                    <option value="2">Moyenne</option>
                    <option value="3">Haute</option>
                </select>
                <br>
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
            <select name="saison" id="saison">
                    <option value="1">Basse</option>
                    <option value="2">Moyenne</option>
                    <option value="3">Haute</option>
                </select>            
            <input type="submit" value="Envoyer">
        </form>
    <?php
    // On informe des semaines ajouté ou non 
    }elseif($requete){
        foreach($semaine_a_ajouter as $value){
            echo "La semaine commencant le : " . $value . " a été ajouté dans la base <br>";
        }
        if(!$semaine_dans_base){
            echo '<button onclick="location.href = \'./ajout_semaines.php\';">Retour</button>';
        }
    }
    if ($semaine_dans_base){
        foreach($semaine_deja_enregistre as $value){
            echo "La semaine commencant le : " . $value . " est déja enregistrée dans la base, elle n'a donc pas été ajouté <br>";
        }
        echo '<button onclick="location.href = \'./ajout_semaines.php\';">Retour</button>';
    }
    
    
    ?>
    </body>
<?php
include("./footer.html");
?>

</html>
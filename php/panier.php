<?php
session_start();
include 'config.php';
$bdd = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
$idp = $_SESSION['idp'];

$recup = $bdd->prepare("SELECT * FROM CONTENIR WHERE idp = $idp");
$recup->execute();
$panier = $recup->fetchAll();


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/global.css">
    <title>Panier</title>
</head>

<body>
    <?php
    include '../includes/header.php'
    ?>
    <main>
    <?php 
        foreach ($panier as $info): 
    ?>
        <section>
            <img src="../medias/<?= $info['ref']?>.jpg" alt="image <?= $info['ref']?>">
            <p>Référence : <?= $info['ref']?></p>
            <form action="" method="post">
                <input type="number" value="<?= $info['quantite']?>" name="quant<?= $info['ref']?>">
                <input type="submit" value="Modifier la quantité" name="changer">
            </form>
            <?php
            $ref = $info['ref'];
            $newQuant = $_POST['quant'.$info['ref']];

            if(isset($_POST['changer']))
            {
                
                $changer = $bdd->prepare("UPDATE CONTENIR SET quantite = '$newQuant' WHERE ref = '$ref'");
                $changer->execute();
                header("Refresh:0");
            }

            ?>
        </section>
    <?php
        endforeach; 
    ?>
    </main>
</body>
</html>
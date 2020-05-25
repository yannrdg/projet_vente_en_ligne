<?php
session_start();
include 'config.php';

$bdd = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
$info = $bdd->prepare("SELECT * FROM PRODUIT ORDER BY date DESC");
$exec = $info->execute();
$produit = $info->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="yann" content="auhtor">
    <link rel="stylesheet" href="../style/global.css">
    <title>Acceuil</title>
</head>

<body>
    <?php
    include '../includes/header.php';
?>
    <main>
        <?php foreach ($produit as $items): 
          if($items['type'] == 'ballon')  
          {
        ?>
        <section class="<?= $items['type']?>">
            <div>
                <h3><?= $items['nom']?></h3>
                <p><?= $items['descriptif']?></p>
                <p>Référence : <?= $items['ref']?></p>
            </div>
            <img src="../medias/<?= $items['ref']?>/.jpeg" alt="image">
        </section>
        <?php 
            }
            endforeach; 
        ?>
    </main>
</body>

</html>
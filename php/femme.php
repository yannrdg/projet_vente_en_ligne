<?php
session_start();
include 'config.php';
$bdd = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
$info = $bdd->prepare("SELECT * FROM produit ORDER BY date DESC");
$exec = $info->execute();
$produit = $info->fetchAll();
if(isset($_POST['veste']))
{
    $foot = $bdd->prepare("SELECT * FROM produit WHERE nom LIKE '%veste%' ORDER BY date DESC");
    $exec = $foot->execute();
    $produit = $foot->fetchAll();; 
}
elseif(isset($_POST['short']))
{
    $hand = $bdd->prepare("SELECT * FROM produit WHERE nom LIKE '%short%' ORDER BY date DESC");
    $exec = $hand->execute();
    $produit = $hand->fetchAll();; 
}
elseif(isset($_POST['tshirt']))
{
    $hand = $bdd->prepare("SELECT * FROM produit WHERE nom LIKE '%t-shirt%' ORDER BY date DESC");
    $exec = $hand->execute();
    $produit = $hand->fetchAll();; 
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="yann" content="auhtor">
    <link rel="stylesheet" href="../style/global.css">
    <link rel="stylesheet" href="../style/produit.css">
    <title>Handball</title>
</head>
<body>
    <?php
    include '../includes/header.php';
?>
    <main>
        <form action="" method="post">
            <input type="submit" name="tshirt" value="T-shirt">
            <input type="submit" name="short" value="Short">
            <input type="submit" name="veste" value="Veste">
        </form>
        <?php foreach ($produit as $items): 
            if($items['type'] == 'femme')  
            {
            include '../includes/produit.php';
            }
            endforeach; 
        ?>
    </main>
</body>
</html>
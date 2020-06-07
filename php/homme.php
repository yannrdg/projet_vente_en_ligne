<?php
session_start();
include 'config.php';
$bdd = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
//Création d'un compteur. Si l'utilisateur est connecté, l'id de la page que j'ai choisi, s'ajoute avec son login dans la table 'visiter'
if(isset($_SESSION['login']))
{
    $login = $_SESSION['login'];
    $idpage = 1;
    $compteur = $bdd->prepare("INSERT INTO visiter (login, idpage) VALUES (:login, :idpage)");
    $compteur->bindParam(':login', $login);
    $compteur->bindParam(':idpage', $idpage);
    $compteur->execute();
}
$homme = $bdd->prepare("SELECT * FROM produit ORDER BY date DESC");
$exec = $homme->execute();
$produit = $homme->fetchAll();
if(isset($_POST['veste']))
{
    $homme = $bdd->prepare("SELECT * FROM produit WHERE nom LIKE '%veste%' ORDER BY date DESC");
    $exec = $homme->execute();
    $produit = $homme->fetchAll();
}
elseif(isset($_POST['short']))
{
    $homme = $bdd->prepare("SELECT * FROM produit WHERE nom LIKE '%short%' ORDER BY date DESC");
    $exec = $homme->execute();
    $produit = $homme->fetchAll();
}
elseif(isset($_POST['tshirt']))
{
    $homme = $bdd->prepare("SELECT * FROM produit WHERE nom LIKE '%t-shirt%' ORDER BY date DESC");
    $exec = $homme->execute();
    $produit = $homme->fetchAll();
}
elseif(isset($_POST['all']))
{
    $homme = $bdd->prepare("SELECT * FROM produit ORDER BY date DESC");
    $exec = $homme->execute();
    $produit = $homme->fetchAll();; 
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="yann" content="auhtor">
    <link rel="stylesheet" href="../style/global.css">
    <link rel="stylesheet" href="../style/produit.css">
    <title>Football</title>
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
            <input type="submit" name="all" value="Tous">
        </form>
        <?php foreach ($produit as $items): 
            if($items['type'] == 'homme')  
            {
            include '../includes/produit.php';
            }
            endforeach; 
        ?>
    </main>
</body>
</html>
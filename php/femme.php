<?php
session_start();
include 'config.php';
$bdd = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);

//Création d'un compteur. Si l'utilisateur est connecté, l'id de la page que j'ai choisi, s'ajoute avec son login dans la table 'visiter'
if(isset($_SESSION['login']))
{
    $login = $_SESSION['login'];
    $idpage = 2;
    $compteur = $bdd->prepare("INSERT INTO visiter (login, idpage) VALUES (:login, :idpage)");
    $compteur->bindParam(':login', $login);
    $compteur->bindParam(':idpage', $idpage);
    $compteur->execute();
}
$femme = $bdd->prepare("SELECT * FROM produit ORDER BY date DESC");
$exec = $femme->execute();
$produit = $femme->fetchAll();
if(isset($_POST['veste']))
{
    $femme = $bdd->prepare("SELECT * FROM produit WHERE nom LIKE '%veste%' ORDER BY date DESC");
    $exec = $femme->execute();
    $produit = $femme->fetchAll();; 
}
elseif(isset($_POST['short']))
{
    $femme = $bdd->prepare("SELECT * FROM produit WHERE nom LIKE '%short%' ORDER BY date DESC");
    $exec = $femme->execute();
    $produit = $femme->fetchAll();; 
}
elseif(isset($_POST['tshirt']))
{
    $femme = $bdd->prepare("SELECT * FROM produit WHERE nom LIKE '%t-shirt%' ORDER BY date DESC");
    $exec = $femme->execute();
    $produit = $femme->fetchAll();; 
}
elseif(isset($_POST['all']))
{
    $femme = $bdd->prepare("SELECT * FROM produit ORDER BY date DESC");
    $exec = $femme->execute();
    $produit = $femme->fetchAll();
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
            <input type="submit" name="all" value="Tous">
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
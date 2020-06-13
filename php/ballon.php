<?php
session_start();
include 'config.php';
$bdd = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
//Création d'un compteur. Si l'utilisateur est connecté, l'id de la page que j'ai choisi, s'ajoute avec son login dans la table 'visiter'
if(isset($_SESSION['login']))
{
    $login = $_SESSION['login'];
    $idpage = 3;
    $compteur = $bdd->prepare("INSERT INTO visiter (login, idpage) VALUES (?, ?)");
    $compteur->execute(array($login, $idpage));
}
$info = $bdd->prepare("SELECT * FROM produit ORDER BY date DESC");
$exec = $info->execute();
$produit = $info->fetchAll();
//Bouton de tri
if(isset($_POST['foot']))
{
    $foot = $bdd->prepare("SELECT * FROM produit WHERE nom LIKE '%football%' ORDER BY date DESC");
    $exec = $foot->execute();
    $produit = $foot->fetchAll();; 
}
elseif(isset($_POST['hand']))
{
    $hand = $bdd->prepare("SELECT * FROM produit WHERE nom LIKE '%handball%' ORDER BY date DESC");
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
    <title>Ballon</title>
</head>
<body>
    <?php
    include '../includes/header.php';
?>
    <main>
        <form action="" method="post">
            <input type="submit" name="foot" value="Football">
            <input type="submit" name="hand" value="Handball">
            <input type="submit" name="all" value="Tous">
        </form>
        <?php foreach ($produit as $items): 
            if($items['type'] == 'ballon')  
            {
            include '../includes/produit.php';
            }
            endforeach; 
        ?>
    </main>
    <?php
    include '../includes/footer.php';
    ?>
</body>
</html>
<?php
session_start();
include 'config.php';
$bdd = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);

if(isset($_POST['femme']))
{
    $femme = $bdd->prepare("SELECT * FROM PRODUIT WHERE nom LIKE '%femme%' ORDER BY date DESC");
    $exec = $femme->execute();
    $produit = $femme->fetchAll();; 
}
elseif(isset($_POST['hand']))
{
    $homme = $bdd->prepare("SELECT * FROM PRODUIT WHERE nom LIKE '%homme%' ORDER BY date DESC");
    $exec = $homme->execute();
    $produit = $homme->fetchAll();; 
}
else
{
$info = $bdd->prepare("SELECT * FROM PRODUIT ORDER BY date DESC");
$exec = $info->execute();
$produit = $info->fetchAll();
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
        <form action="" method="post" enctype="multipart/form-data">
            <input type="submit" name="Femme" value="Femme">
            <input type="submit" name="Homme" value="Homme">
            <input type="submit" name="all" value="Tous">
        </form>
        <?php foreach ($produit as $items): 
            if($items['type'] == 'football')  
            {
            include '../includes/produit.php';
            }
            endforeach; 
        ?>
    </main>
</body>

</html>
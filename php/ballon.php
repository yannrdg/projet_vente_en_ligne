<?php
session_start();
include 'config.php';
$bdd = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);

$info = $bdd->prepare("SELECT * FROM PRODUIT ORDER BY date DESC");
$exec = $info->execute();
$produit = $info->fetchAll();

//Bouton de tri

if(isset($_POST['foot']))
{
    $foot = $bdd->prepare("SELECT * FROM PRODUIT WHERE nom LIKE '%football%' ORDER BY date DESC");
    $exec = $foot->execute();
    $produit = $foot->fetchAll();; 
}
elseif(isset($_POST['hand']))
{
    $hand = $bdd->prepare("SELECT * FROM PRODUIT WHERE nom LIKE '%handball%' ORDER BY date DESC");
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
        <form action="" method="post" enctype="multipart/form-data">
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
</body>

</html>
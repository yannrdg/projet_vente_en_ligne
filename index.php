<?php
session_start();
include 'php/config.php';

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
    <link rel="stylesheet" href="style/global.css">
    <title>Acceuil</title>
</head>
<body>
<header>
    <a href="index.php" id="logo"><img src="medias/Select_logo.png" alt="logo Select"></a>
    <div>
        <input type="text" name="recherche" placeholder="Que recherchez-vous ?">
        <input type="submit" name="demande" value="&#128269;">
    </div>
    <?php
            if(isset($_SESSION['login']))
            {
        ?>
    <nav id="deroulant">
        <a>Mon profil</a>
        <ul>
            <li><a id="profil" href="php/profil.php">Gérer mon profil</a></li>
            <li><a id="deco" href="php/deconnexion.php">Deconnectez-vous</a></li>
            
        </ul>
    </nav>
    <a id="panier" href="php/panier.php">Mon panier</a>

    <?php
            }
            else
            {
        ?>
    <a href="php/connexion.php">Identifiez-vous</a>
    <a href="php/inscription.php">Rejoignez-nous</a>
    <?php                
            }
        ?>
</header>
<main>
<?php foreach ($produit as $items): ?>  
                <section class="<?= $items['type']?>">
            <div>
                <h3><?= $items['nom']?></h3>
                <p><?= $items['descriptif']?></p>
                <p>Référence : <?= $items['ref']?></p>
            </div>
            <img src="medias/<?= $items['ref']?>.jpeg" src="medias/<?= $items['nom']?>.jpeg"
                alt="image">
        </section>
            <?php endforeach; ?>
</main>
</body>
</html>
<?php
session_start();
include 'php/config.php';

$bdd = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
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
            <input type="search" name="recherche" placeholder="Que recherchez-vous ?">
            <input type="submit" name="demande" value="&#128269;">
        </div>
        <?php
            if(isset($_SESSION['login']))
            {
        ?>  
              <nav id="deroulant">
                    <ul>
                        <li>
                            <h3>Mon profil</h3>
                            <ul>
                                <li><a id="profil" href="php/profil.php">Gérer mon profil</a></li>
                                <li><a id="panier" href="php/panier.php">Mon panier</a></li>
                            </ul>      
                        </li>
                    </ul>                
            </nav>
            <a id="deco" href="php/deconnexion.php">Deconnectez-vous</a>
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
</body>
</html>
<?php
session_start();
include 'config.php';

$bdd = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);

if(isset($_SESSION['login']))
{

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="yann" content="auhtor">
    <title>Acceuil</title>
</head>
<body>
    <header>
        <!--<img src="../medias/Select_logo.png" alt="logo select">-->
        <p>Profil de <?php echo $_SESSION["login"]; ?></p>
        <a href="deconnexion.php">Déconnexion</a>
    </header>
</body>
</html>
<?php
}


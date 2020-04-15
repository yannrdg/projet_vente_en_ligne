<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=projet', 'root', 'root');

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
        <a href="deconnexion.php">Deconnexion</a>
    </header>
</body>
</html>
<?php
}


<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=projet', 'root', 'root');

if(isset($_SESSION['login']))
{

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h2>Profil de <?php echo $_SESSION["login"]; ?></h2>
<p><?php
        if(isset($erreur))
        {
            echo $erreur;
        }
        ?></p>
</body>
</html>
<?php
}

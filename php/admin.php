<?php
session_start();
if($_SESSION['login'] == 'admin')
{
include 'config.php';

$bdd = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    $ref = $_POST['ref'];
    $nom = $_POST['nom'];
    $descriptif = $_POST['descriptif'];
    if(isset($_POST['ajout']))
    {
        if(!empty($ref) && !empty($nom) && !empty($descriptif))
        {       
            $reflength = strlen($ref);
            if($reflength === 5)
            {
                $req = $bdd->prepare("INSERT INTO PRODUIT (ref, nom, descriptif) VALUES ('$ref', '$nom', '$descriptif')");
                $req->execute();
                header('Location: ../index.php');
            }
            else
            {
                echo "La référence de l'article doit faire 5 chiffres";
            }
        }
        else
        {
            echo 'il manque des infos';
        }
    }   

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="yann" content="auhtor">
    <link rel="stylesheet" href="../style/global.css">
    <title>Session visiteur</title>
</head>
<body>

</body>
<h1>ajout</h1>
<form action="" method="post" enctype="">
<div>
    <label for="ref"></label>
    <input type="number" id="ref" maxlength="5" name="ref">
</div>
<div>
    <label for="nom"></label>
    <input type="text" id="nom" maxlength="20" name="nom">
</div>
<div>
    <label for="descriptif"></label>
    <input type="text" id="descriptif" name="descriptif" maxlength="50">
</div>
<input type="submit" name="ajout" value="ajouter un article">
</form>
</html>
<?php
}
header ('Location: ../index.php');
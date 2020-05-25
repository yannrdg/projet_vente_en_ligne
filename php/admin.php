<?php
session_start();
if($_SESSION['login'] == 'admin')
{
include 'config.php';

$bdd = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);

    $ref = $_POST['ref'];
    $nom = $_POST['nom'];
    $descriptif = $_POST['descriptif'];
    $type = $_POST['type'];
    $filename = $_FILES['file']['name'];
    $filetmpname = $_FILES['file']['tmp_name'];
    $folder = '../medias/';

    if(isset($_POST['ajout']))
    {
        if(!empty($ref) && !empty($nom) && !empty($descriptif))
        {       
            move_uploaded_file($filetmpname, $folder.$filename);
            $reflength = strlen($ref);
            if($reflength === 5)
            {

                $req = $bdd->prepare("INSERT INTO PRODUIT (ref, nom, descriptif, type) VALUES ('$ref', '$nom', '$descriptif', '$type')");
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
    <h1>ajout</h1>
    <form action="" method="post" enctype="multipart/form-data">
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
        <div>
                <label for="type">Catégorie :</label>
                <select name="type" id="type">
                    <option value="ballon">ballon</option>
                    <option value="handball">handball</option>
                    <option value="football">football</option>
                    <option value="tshirt">t-shirt</option>
                </select>
        </div>
        <div>
        <label for="">File up</label>
        <input type="file" name="file" value="déposez">
        </div>
        <input type="submit" name="ajout" value="ajouter un article">
    </form>
</body>

</html>
<?php
}
else
{
 header('Location: ../index.php');
}
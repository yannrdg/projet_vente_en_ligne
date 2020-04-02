<?php
$bdd = new PDO('mysql:host=localhost;dbname=test', 'root', 'root');

$mailconnnect = htmlspecialchars($_POST['mailconnect']);
$mdpconnnect = $_POST['mdpconnect'];

if(isset($_POST['formconnect']))
{
    if(!empty($mailconnnect) AND !empty($mdpconnnect))
    {
        $requser = $bdd->prepare("SELECT * FROM membres WHERE mail = ? AND motdepasse = ?");
        $requser->execute(array($mailconnnect, $mdpconnnect));
        $userexist = $requser->rowCount();
        if($userexist == 1)
        {
            $userinfo = $requser->fetch();
            $_SESSION['id'] = $userinfo['id'];
            $_SESSION['pseudo'] = $userinfo['pseudo'];
            $_SESSION['mail'] = $userinfo['mail'];
            header("Location: profil.php?id=".$_SESSION['id']);
        }
        else 
        {
            $erreur = "Mauvais identifiants";
        }
    } 
    else 
    {
        $erreur = "Tout les champs doivent être complétés";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h1>Connexion</h1>

<form action="" method="POST">
    <div>
        <label for="mailconnect">Mail : </label>
        <input type="mail" id="mailconnect" name="mailconnect">
    </div>
    <div>
        <label for="mdpconnect">Mot de passe : </label>
        <input type="password" id="mdpconnect" name="mdpconnect">
    </div>
    <div id="submit">
        <input type="submit" value="Connexion" name="formconnect">
    </div>
</form>
<p><?php
        if(isset($erreur))
        {
            echo $erreur;
        }
        ?></p>
</body>
</html>
<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=projet', 'root', 'root');

if(isset($_POST['formconnect']))
{
    $mailconnnect = htmlspecialchars($_POST['mailconnect']);
    $mdpconnnect = $_POST['mdpconnect'];
    if(!empty($mailconnnect) AND !empty($mdpconnnect))
    {
        $requser = $bdd->prepare("SELECT * FROM VISITEUR WHERE mdp = ? AND mail = ?");
        $requser->execute(array($mdpconnnect, $mailconnnect));
        $userexist = $requser->rowCount();
        if($userexist == 1)
        {
            $userinfo = $requser->fetch();
            $_SESSION['login'] = $userinfo['login'];
            $_SESSION['mail'] = $userinfo['mail'];
            header("Location: session.php");
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
    <meta name="yann" content="autho">
    <link rel="stylesheet" href="../style/connexion.css">
    <title>Connexion</title>
</head>

<body>
    <img src="../medias/Select_logo.png" alt="">
    <h1>S'identifier</h1>

    <form action="" method="POST">
        <div>
            <label for="mailconnect">Votre e-mail</label>
            <input type="email" id="mailconnect" name="mailconnect">
        </div>
        <div>
            <label for="mdpconnect">Votre mot de passe</label>
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
    <a href="../index.php">Accueil</a>
</body>

</html>
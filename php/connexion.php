<?php
session_start();
if(isset($_SESSION['mail']))
{
    header('Location: ../index.php');
}
session_start();
include 'config.php';
$bdd = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
$idconnnect = htmlspecialchars($_POST['idconnect']);
$mdpconnect = sha1($_POST['mdpconnect']);
if(isset($_POST['formconnect']))
{
    if(!empty($idconnnect) && !empty($mdpconnect))
    {
        $requser = $bdd->prepare("SELECT * FROM visiteur WHERE (login = '$idconnnect' || mail = '$idconnnect') && mdp = '$mdpconnect'");
        $requser->execute(array($idconnnect, $mdpconnect));
        $userexist = $requser->rowCount();
        if($userexist == 1)
        {
            $userinfo = $requser->fetch();
            $_SESSION['login'] = $userinfo['login'];
            $_SESSION['mail'] = $userinfo['mail'];
            $_SESSION['idp'] = $userinfo['idp'];
            if($idconnnect == 'admin')
            {
                header('Location: ../index.php');
            }
            else
            {
                header('Location: ../index.php');
            }
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
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="yann" content="autho">
    <link rel="stylesheet" href="../style/connexion.css">
    <link rel="stylesheet" href="../style/global.css">
    <title>Connexion</title>
</head>
<body>
    <?php
        include '../includes/header.php';
    ?>
    <main>
        <section>
            <h1>S'identifier</h1>
            <p>
            <form action="" method="POST">
                <div>
                    <label for="idconnect">Votre e-mail ou votre login</label>
                    <input type="text" id="idconnect" name="idconnect" value="<?php if(isset($idconnnect)) {echo $idconnnect;} ?>">
                </div>
                <div>
                    <label for="mdpconnect">Votre mot de passe</label>
                    <input type="password" id="mdpconnect" name="mdpconnect">
                </div>
                <div id="submit">
                    <input type="submit" value="Connexion" name="formconnect">
                </div>
                <p><?php
                if(isset($erreur))
                {
                    echo $erreur;
                }
                ?></p>
            </form>
            <a href="inscription.php">Première connexion</a>
        </section>
    </main>
    <?php
    include '../includes/footer.php';
    ?>
</body>
</html>
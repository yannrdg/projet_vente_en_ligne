<?php
session_start();
if(isset($_SESSION['mail']))
{
    header('Location: ../index.php');
}
session_start();
include 'config.php';

$bdd = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
$mailconnnect = htmlspecialchars($_POST['mailconnect']);
$mdpconnect = sha1($_POST['mdpconnect']);

if(isset($_POST['formconnect']))
{
    if(!empty($mailconnnect) && !empty($mdpconnect))
    {
        $requser = $bdd->prepare("SELECT * FROM VISITEUR WHERE mdp = ? AND mail = ?");
        $requser->execute(array($mdpconnect, $mailconnnect));
        $userexist = $requser->rowCount();
        if($userexist == 1)
        {
            $userinfo = $requser->fetch();
            $_SESSION['login'] = $userinfo['login'];
            $_SESSION['mail'] = $userinfo['mail'];
            header('Location: ../index.php');
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
    <link rel="stylesheet" href="../style/global.css">
    <title>Connexion</title>
</head>

<body>
<?php
    include  '../includes/header.php';
?>
    <main>
        <section>
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
</body>

</html>
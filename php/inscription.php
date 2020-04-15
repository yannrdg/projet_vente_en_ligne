<?php

    $login = htmlspecialchars($_POST['login']);
    $mail = htmlspecialchars($_POST['mail']);
    $mail2 = htmlspecialchars($_POST['mail2']);
    $mdp = $_POST['mdp'];
    $mdp2 = $_POST['mdp2'];
    $nom = htmlspecialchars($_POST['nom']);
    $numero = $_POST['numero'];
    $rue = htmlspecialchars($_POST['rue']);
    $cp = $_POST['cp'];
    $ville = htmlspecialchars($_POST['ville']);
    $cb = $_POST['cb'];

try
{
    $bdd = new PDO('mysql:host=localhost;dbname=projet', 'root', 'root');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    if(isset($_POST['forminscription']))
        {
        
    
    
        if(!empty($_POST['login']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2']) AND !empty($_POST['mail']) AND !empty($_POST['mail2']) AND !empty($_POST['nom']) AND !empty($_POST['numero']) AND !empty($_POST['rue']) AND !empty($_POST['cp']) AND !empty($_POST['ville']) AND !empty($_POST['cb']) )
        {   
    
            $loginlenght = strlen($login);
            if($loginlenght <= 20) 
            {
                if($mail == $mail2)
                {
                    if(filter_var($mail, FILTER_VALIDATE_EMAIL))
                    {
                        if($mdp == $mdp2)
                        {
                        $sth = $bdd->prepare("INSERT INTO VISITEUR(login, mdp, mail, nom, numero, rue, cp, ville, cb) VALUES (:login, :mdp, :mail, :nom, :numero, :rue, :cp, :ville, :cb)");  
                        $sth->bindParam(':login',$login);
                        $sth->bindParam(':mdp',$mdp);
                        $sth->bindParam(':mail',$mail);
                        $sth->bindParam(':nom',$nom);
                        $sth->bindParam(':numero',$numero);
                        $sth->bindParam(':rue',$rue);
                        $sth->bindParam(':cp',$cp);
                        $sth->bindParam(':ville',$ville);
                        $sth->bindParam(':cb',$cb);
                        $sth->execute();
                        $ajoutlogin = $bdd->prepare("INSERT INTO visiter (login) SELECT login FROM visiteur");
                        $ajoutlogin->execute(array($login));
                        header('Location: ../index.php');
                        exit;
                        }
                        else 
                        {
                            $erreur = "Vos mdp ne correpsondent pas";
                        }
                    }
                    else 
                    {
                        $erreur = "Votre adresse mail n'est pas valide";
                    }
                }
                else 
                {
                    $erreur = "Vos mail ne correpsondent pas";
                }
            } 
            else 
            {
                $erreur = "Login doit être inférieur à 20 caratères";
            }
        }
        else 
        {
          $erreur = "Tous les champs doivent être complétés";
        }
    }
    
} catch(PPDOException $Exception)
{
    echo 'Impossible de traiter les données. Erreur : '.$Exception->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/inscription.css">
    <title>Document</title>
</head>

<body>
    <h1>Formulaire d'inscription</h1>

    <form action="" method="POST">
        <div>
            <label for="pseudo">Login : </label>
            <input type="text" id="login" name="login" value="<?php if(isset($login)){ echo $login; } ?>">
        </div>
        <div>
            <label for="mdp">Mot de passe : </label>
            <input type="password" id="mdp" name="mdp">
        </div>
        <div>
            <label for="mdp2">Confirmez votre mot de passe : </label>
            <input type="password" id="mdp2" name="mdp2">
        </div>
        <div>
            <label for="mail">Email : </label>
            <input type="email" id="mail" name="mail" value="<?php if(isset($mail)){ echo $mail; } ?>">
        </div>
        <div>
            <label for="mail2">Confirmez votre email : </label>
            <input type="email" id="mail2" name="mail2" value="<?php if(isset($mail2)){ echo $mail2; } ?>">
        </div>
        <div>
            <label for="nom">Nom <i>(en majuscule)</i> : </label>
            <input type="text" id="nom" name="nom" value="<?php if(isset($nom)){ echo $nom; } ?>">
        </div>
        <div>
            <label for="numero">Numéro de la rue : </label>
            <input type="number" id="numero" name="numero" value="<?php if(isset($numero)){ echo $numero; } ?>">
        </div>
        <div>
            <label for="rue">Rue : </label>
            <input type="text" id="rue" name="rue" value="<?php if(isset($rue)){ echo $rue; } ?>">
        </div>
        <div>
            <label for="cp">Code postal : </label>
            <input type="number" id="cp" name="cp" value="<?php if(isset($cp)){ echo $cp; } ?>">
        </div>
        <div>
            <label for="ville">Ville : </label>
            <input type="text" id="ville" name="ville" value="<?php if(isset($ville)){ echo $ville; } ?>">
        </div>
        <div>
            <label for="cb">Carte bancaire : </label>
            <input type="number" id="cb" name="cb" value="<?php if(isset($cb)){ echo $cb; } ?>">
        </div>
        <div id="submit">
            <input type="submit" value="Je m'inscris" name="forminscription">
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
<?php

$bdd = new PDO('mysql:host=localhost;dbname=test', 'root', 'root');

if(isset($_POST['forminscription']))
{
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $mail = htmlspecialchars($_POST['mail']);
    $mail2 = htmlspecialchars($_POST['mail2']);
    $mdp = $_POST['mdp'];
    $mdp2 = $_POST['mdp2'];

    if(!empty($_POST['pseudo']) AND !empty($_POST['mail']) AND !empty($_POST['mail2']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2']))
    {   

        $pseudolenght = strlen($pseudo);
        if($pseudolenght <= 255) 
        {
            if($mail == $mail2)
            {
                if(filter_var($mail, FILTER_VALIDATE_EMAIL))
                {
                    if($mdp == $mdp2)
                    {
                    $sth = $bdd->prepare("INSERT INTO membres(pseudo, mail, motdepasse) VALUES(:pseudo, :mail, :mdp)");  
                    $sth->bindParam(':pseudo',$pseudo);
                    $sth->bindParam(':mdp',$mdp);
                    $sth->bindParam(':mail',$mail);
                    $sth->execute();
                    $erreur = "Votre compte a bien été créé";
                    }
                    else 
                    {
                        $erreur = "Vos mdp ne correspondent pas";
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
            $erreur = "Login doit être inférieur à 30 caratères";
        }
    }
    else 
    {
      $erreur = "Tous les champs doivent être complétés";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>Document</title>
</head>
<body>
    <h1>Inscription PHP</h1>
        
        <form action="" method="POST">
            <div>
                <label for="pseudo">Pseudo : </label>
                <input type="text" id="pseudo" name="pseudo" value="<?php if(isset($pseudo)){ echo $pseudo; } ?>">
            </div>
            <div>
                <label for="mail">Email : </label>
                <input type="email" id="mail" name="mail" value="<?php if(isset($pseudo)){ echo $mail; } ?>">
            </div>
            <div>
                <label for="mail2">Confirmation de mon email : </label>
                <input type="email" id="mail2" name="mail2" value="<?php if(isset($pseudo)){ echo $mail2; } ?>">
            </div>
            <div>
                <label for="mdp">Mot de passe : </label>
                <input type="password" id="mdp" name="mdp" >
            </div>
            <div>
                <label for="mdp2">Confirmation du mot de passe : </label>
                <input type="password" id="mdp2" name="mdp2">
            </div>
            <div id="submit">
                <input type="submit" value="Je m'inscris" name="forminscription">
            </div>
        </form>
        <?php
        if(isset($erreur))
        {
            echo '<font color="red">'.$erreur."</font>";
        }
        ?>
</body>
</html>
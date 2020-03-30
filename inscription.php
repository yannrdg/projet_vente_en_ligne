<!DOCTYPE html>
<html>
    <head>
        <title>Page de traitement</title>
        <meta charset="utf-8">
    </head>
    <body>
        <p>Dans le formulaire précédent, vous avez fourni les
        informations suivantes :</p>
        
        <?php
            echo 'Login : '.$_POST["nom"].'<br>';
            echo 'Mot de passe : ' .$_POST["mdp"].'<br>';
            echo 'mail : ' .$_POST["mail"].'<br>';
            echo 'nom : ' .$_POST["nom"].'<br>';
            echo 'numero : ' .$_POST["numero"].'<br>';
            echo 'rue : ' .$_POST["rue"].'<br>';
            echo 'cp : ' .$_POST["cp"].'<br>';
            echo 'ville : ' .$_POST["ville"].'<br>';
            echo 'cb : ' .$_POST["cb"].'<br>';
        ?>
    </body>
</html>
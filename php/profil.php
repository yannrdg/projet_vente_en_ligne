<?php
session_start();
include 'config.php';
$bdd = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);

$profil = $bdd->prepare("SELECT * FROM visiteur WHERE idp = :idp");
$profil->bindParam(':idp', $_SESSION['idp']);
$profil->execute();
$infoProfil = $profil->fetchAll();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/global.css">
    <script src="../script/profil.js" async></script>
    <title>Profil</title>
</head>
<body>
    <?php
    include '../includes/header.php';
    ?>
    <main>
    <button id="modifierInfos">Modifier le profil</button>
    <button id="annuler">Annuler</button>
    <?php
    foreach($infoProfil as $infos):  
    ?>  
        <section id=infos>
            <p><?=$infos['login']?></p>
            <p><?=$infos['mail']?></p>
            <p><?=$infos['nom']?></p>
            <p><?=$infos['numero']?></p>
            <p><?=$infos['rue']?></p>
            <p><?=$infos['cp']?></p>
            <p><?=$infos['ville']?></p>
            <p><?=$infos['cb']?></p>
        </section>
        <section id="modif">
            <form action="" method="post">
            <input type="text" value="<?=$infos['nom']?>" name="newNom" maxlength="20">
            <input type="number" value="<?=$infos['numero']?>" name="newNumero" size="15" maxlength="11">
            <input type="text" value="<?=$infos['rue']?>" name="newRue" maxlength="100">
            <input type="number" value="<?=$infos['cp']?>" name="newCp" maxlength="5">
            <input type="text" value="<?=$infos['ville']?>" name="newVille" maxlength="50">
            <input type="number" value="<?=$infos['cb']?>" name="newCb" maxlength="16">
            <input type="submit" name="modifier" value="Modifier">
            </form>
    <?php       
    endforeach;
    $newLogin = htmlspecialchars($_POST['newLogin']);
    $newMail = htmlspecialchars($_POST['newMail']);
    $newNom = htmlspecialchars($_POST['newNom']);
    $newNumero = $_POST['newNumero'];
    $newRue = htmlspecialchars($_POST['newRue']);
    $newCp = $_POST['newCp'];
    $newVille = htmlspecialchars($_POST['newVille']);
    $newCb = $_POST['newCb'];

    if(isset($_POST['modifier']))
    {
        if(!empty($newNom) && !empty($newNumero) && !empty($newRue) && !empty($newCp) && !empty($newVille) && !empty($newCb))
        {
            if(is_numeric($newNumero) == true )
            {
                $sth = $bdd->prepare("UPDATE visiteur SET nom = :nom, numero = :numero, rue = :rue, cp = :cp, ville = :ville, cb = :cb");  
                $sth->bindParam(':nom',$newNom);
                $sth->bindParam(':numero',$newNumero);
                $sth->bindParam(':rue',$newRue);
                $sth->bindParam(':cp',$newCp);
                $sth->bindParam(':ville',$newVille);
                $sth->bindParam(':cb',$newCb);
                $sth->execute();
                header("refresh:0;url=profil.php");
            }
            else
            {
                echo "Votre numéro ne doit comporter que des chiffres";
            }
        } 
        else
        {                   
        echo "Tous les champs doivent être complétés";
        }
    }
    ?>
            </section>
    </main>
</body>
</html>
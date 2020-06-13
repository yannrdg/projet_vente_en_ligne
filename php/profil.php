<?php
session_start();
if($_SESSION['idp'])
{
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
    <link rel="stylesheet" href="../style/profil.css">
    <script src="../script/profil.js" async></script>
    <title>Profil</title>
</head>

<body>
    <?php
    include '../includes/header.php';
    ?>
    <main>
        <h2>Mon profil</h2>
        <?php
    foreach($infoProfil as $infos):  
    ?>
        <section id=infos>
            <p><i>Si vous avez modifié vos informations, merci d'actualiser la page pour voir ces modifications !</i></p>
            <h5>Mes informations personnelles</h5>
            <p><i>Login : </i><?=$infos['login']?></p>
            <p><i>Mon adresse mail : </i><?=$infos['mail']?></p>
            <p><i>Nom de famille : </i><?=$infos['nom']?></p>
            <p><i>Mon numéro de téléphone : </i>0<?=$infos['numero']?></p>
            <h5>Mon adresse de livraison</h5>
            <p><i>Rue : </i><?=$infos['rue']?></p>
            <p><i>Code postal : </i><?=$infos['cp']?></p>
            <p>Ville : <?=$infos['ville']?></p>
            <h5>Mes coordonnées bancaire</h5>
            <p><i>Mon numéro de carte bancaire : </i><?=$infos['cb']?></p>
        </section>
        <section id="modif">
            <form action="" method="post">
                <h5>Mes informations personnelles</h5>
                <div>
                    <label for="nom">Nom de famille <i>(En majuscule)</i> : </label>
                    <input type="text" value="<?=$infos['nom']?>" name="newNom" maxlength="20" id="nom">
                </div>
                <div>
                    <label for="numero">Mon numéro de téléphone : </label>
                    <input type="number" value="0<?=$infos['numero']?>" name="newNumero" size="15" maxlength="11"
                        id="numero">
                </div>
                <h5>Mon adresse de livraison</h5>
                <div>
                    <label for="rue">Rue : </label>
                    <input type="text" value="<?=$infos['rue']?>" name="newRue" maxlength="100" id="rue">
                </div>
                <div>
                    <label for="cp">Code postal : </label>
                    <input type="number" value="<?=$infos['cp']?>" name="newCp" maxlength="5" id="cp">
                </div>
                <div>
                    <label for="ville">Ville : </label>
                    <input type="text" value="<?=$infos['ville']?>" name="newVille" maxlength="50" id="ville">
                </div>
                <h5>Mes coordonées bancaire</h5>
                <div>
                    <label for="cb">Mon numéro de carte bancaire : </label>
                    <input type="number" value="<?=$infos['cb']?>" name="newCb" maxlength="16" id="cb">
                </div>
                <div>
                    <input type="submit" name="modifier" value="Modifier" id="modifier">
                    <button id="annuler">Annuler</button>
                </div>
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
                $sth = $bdd->prepare("UPDATE visiteur SET nom = :nom, numero = :numero, rue = :rue, cp = :cp, ville = :ville, cb = :cb WHERE idp = :idp");  
                $sth->bindParam(':nom',$newNom);
                $sth->bindParam(':numero',$newNumero);
                $sth->bindParam(':rue',$newRue);
                $sth->bindParam(':cp',$newCp);
                $sth->bindParam(':ville',$newVille);
                $sth->bindParam(':cb',$newCb);
                $sth->bindParam(':idp',$_SESSION['idp']);
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
        <button id="modifierInfos">Modifier le profil</button>
    </main>
    <?php
        include '../includes/footer.php';
    ?>
</body>
</html>
<?php
}
else
{
    header('Location: connexion.php');
}
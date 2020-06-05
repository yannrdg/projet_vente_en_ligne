<?php
session_start();
if($_SESSION['login'] == 'admin')
{
    include 'config.php';
    $bdd = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    $refProduit = $_GET['ref'];
    $recupProduit = $bdd->prepare("SELECT * FROM produit WHERE ref = ?");
    $recupProduit->execute(array($refProduit));  
    $produit = $recupProduit->fetchAll();

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification Produit</title>
</head>

<body>
    <form action="" method="post">
        <table>
            <tr>
                <th>Ref</th>
                <th>Nom</th>
                <th>Descriptif</th>
                <th>Type</th>
            </tr>
            <?php
        foreach($produit as $infoProduit):
        ?>
            <tr>
                <td><?= $infoProduit['ref']?></td>
                <td><input type="text" value="<?= $infoProduit['nom']?>" name="newNom<?= $infoProduit['ref']?>"></td>
                <td><input type="text" value="<?= $infoProduit['descriptif']?>" name="newDesc<?= $infoProduit['ref']?>">
                </td>
                <td> <input type="text" value="<?= $infoProduit['type']?>" name="newType<?= $infoProduit['ref']?>"></td>
            </tr>
        </table>
        <?php
        endforeach;
        ?>
        <input type="submit" name="modifier<?= $infoProduit['ref']?>" value="Modifier">
    </form>
    <?php
            $newNom = $_POST['newNom'.$infoProduit['ref']];
            $newDesc = $_POST['newDesc'.$infoProduit['ref']];
            $newRef = $_POST['newRef'.$infoProduit['ref']];
            $newType = $_POST['newType'.$infoProduit['ref']];
            //Modification des informations du porduit
            if(isset($_POST['modifier'.$infoProduit['ref']]))
            {

                $modifProduit = $bdd->prepare("UPDATE produit SET nom = :newNom, descriptif = :newDesc, date = CURRENT_TIMESTAMP, type = :newType WHERE ref = :ref");
                $modifProduit->bindParam(':newNom', $newNom);
                $modifProduit->bindParam(':newDesc', $newDesc);
                $modifProduit->bindParam(':newType', $newType);
                $modifProduit->bindParam(':ref', $refProduit);
                $modifProduit->execute();
                header('Location: admin.php');
            }
        ?>
</body>

</html>
<?php
}
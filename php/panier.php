<?php
session_start();
if($_SESSION['login'])
{
    include 'config.php';
    $bdd = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    $idp = $_SESSION['idp'];
    $recup = $bdd->prepare("SELECT contenir.ref, nom, idp, quantite FROM contenir, produit WHERE produit.ref = contenir.ref AND idp = $idp");
    $recup->execute();
    $panier = $recup->fetchAll();
    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../style/global.css">
        <link rel="stylesheet" href="../style/panier.css">
        <title>Panier</title>
    </head>
    <body>
        <?php
        include '../includes/header.php'
        ?>
        <main>
        <h2>Mon panier</h2>
        <form action="" method="post">
            <input type="submit" name="vider" value="Vider le panier">
        </form>
            <?php
                if(isset($_POST['vider']))
                {
                    $supprimer = $bdd->prepare("DELETE FROM contenir WHERE idp = :idp");
                    $supprimer->bindParam(':idp', $idp);
                    $supprimer->execute();
                }
            foreach ($panier as $info): 
            ?>
            <section>
                <h4><?= $info['nom']?></h4>
                <p>Référence : <?= $info['ref']?></p>
                <img src="../medias/<?= $info['ref']?>.jpg" alt="image <?= $info['ref']?>">
                <form action="" method="post">
                    <input type="number" value="<?= $info['quantite']?>" name="quant<?= $info['ref']?>">
                    <input type="submit" value="Modifier la quantité" name="changer<?= $info['ref']?>"></br>
                    <label for="delete"></label>
                    <input type="submit" value="Supprimer l'article du panier" name="delete<?= $info['ref']?>" id="delete">
                </form>
                <?php
                $newQuant = $_POST['quant'.$info['ref']];
                $ref = $info['ref'];
                if(isset($_POST['changer'.$info['ref']]))
                {
                    $changer = $bdd->prepare("UPDATE contenir SET quantite = :newQuant WHERE ref = :ref AND idp = :idp");
                    $changer->bindParam(':newQuant', $newQuant);
                    $changer->bindParam(':ref', $ref);
                    $changer->bindParam(':idp', $idp);
                    $changer->execute();
                    header("Refresh:0");
                }
                if(isset($_POST['delete'.$info['ref']]))
                {
                    $supprimer = $bdd->prepare("DELETE FROM contenir WHERE ref = :ref");
                    $supprimer->bindParam(':ref', $ref);
                    $supprimer->execute();
                    header("Refresh:0");
                }
                ?>
            </section>
        <?php
            endforeach; 
        ?>
        </main>
    </body>
    </html>
<?php
}
else
{
    header('Location: connexion.php');
}
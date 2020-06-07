<?php
session_start();
if($_SESSION['login'])
{
    include 'config.php';
    $bdd = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    $idp = $_SESSION['idp'];
    $recup = $bdd->prepare("SELECT contenir.ref, nom, idp, quantite, contenir.prix, contenir.prixTotal FROM contenir, produit WHERE produit.ref = contenir.ref AND idp = $idp");
    $recup->execute();
    $panier = $recup->fetchAll();
    // Récupération du statut de la commande
    $reqStatut = $bdd->prepare("SELECT statut FROM paniercde WHERE idp = :idp");
    $reqStatut->bindParam(':idp', $idp);
    $reqStatut->execute();
    $nivStatut = $reqStatut->fetchAll();
    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../style/global.css">
        <link rel="stylesheet" href="../style/panier.css">
        <link rel="stylesheet" href="../style/validation_panier.css">
        <title>Panier</title>
    </head>
    <body>
        <?php
        include '../includes/header.php'
        ?>
        <main>
        <h2>Mon panier</h2>
        <?php
            if($nivStatut[0][0] == -1)
            {
                echo '<div id="nonVal"></div>';
                echo '<div id="val"></div>';
                echo '<div id="priseCompte"></div>';
                echo '<div id="envoye"></div>';
            }
            elseif($nivStatut[0][0] == 0)
            {
                echo '<div id="nonVal" class="bleu"></div>';
                echo '<div id="val"></div>';
                echo '<div id="priseCompte"></div>';
                echo '<div id="envoye"></div>';
            }
        ?>
        <form action="" method="post">
            <input type="submit" name="commander" value="Commander">
            <input type="submit" name="vider" value="Vider le panier">
            <?php
                if(isset($_POST['commander']))
                {
                    $statutPanierValide = 1;
                    $panierAnnule = $bdd->prepare("UPDATE paniercde SET statut = :statut WHERE idp = :idp");
                    $panierAnnule->bindParam(':statut', $statutPanierValide);
                    $panierAnnule->bindParam(':idp', $idp);
                    $panierAnnule->execute();
                    header('Location: validationPanier.php');
                }
                elseif(isset($_POST['vider']))
                {
                    $supprimer = $bdd->prepare("DELETE FROM contenir WHERE idp = :idp");
                    $supprimer->bindParam(':idp', $idp);
                    $supprimer->execute();
                    header("Refresh:0");
                    $statutPanierAnnule = -1;
                    $panierAnnule = $bdd->prepare("UPDATE paniercde SET statut = :statut WHERE idp = :idp");
                    $panierAnnule->bindParam(':statut', $statutPanierAnnule);
                    $panierAnnule->bindParam(':idp', $idp);
                    $panierAnnule->execute();
                    header("Refresh:0");
                }
            ?>
        </form>
        <?php 
            foreach ($panier as $info): 
        ?>
            <section>
                <h4><?= $info['nom']?></h4>
                <p>Référence : <?= $info['ref']?></p>
                <p>Prix unitaire : <?= $info['prix']?></p>
                <p>Prix total : <?= $info['prixTotal']?></p>
                <img src="../medias/<?= $info['ref']?>.jpg" alt="image <?= $info['ref']?>">
                <form action="" method="post">
                    <input type="number" value="<?= $info['quantite']?>" name="quant<?= $info['ref']?>" maxlength="11" min="0">
                    <input type="submit" value="Modifier la quantité" name="changer<?= $info['ref']?>"></br>
                    <label for="delete"></label>
                    <input type="submit" value="Supprimer l'article du panier" name="delete<?= $info['ref']?>" id="delete">
                </form>
                <?php
                $newQuant = $_POST['quant'.$info['ref']];
                $ref = $info['ref'];
                $prixTotal = $info['prix'] * $newQuant;
                if(isset($_POST['changer'.$info['ref']]))
                {
                    $changer = $bdd->prepare("UPDATE contenir SET quantite = :newQuant, prixTotal = :prixTotal WHERE ref = :ref AND idp = :idp");
                    $changer->bindParam(':newQuant', $newQuant);
                    $changer->bindParam(':ref', $ref);
                    $changer->bindParam(':idp', $idp);
                    $changer->bindParam(':prixTotal', $prixTotal);
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
        <p>
        <?php
            $sommeRecup = $bdd->prepare("SELECT ROUND(SUM(prixTotal), 2) FROM contenir WHERE idp = :idp");
            $sommeRecup->bindParam(':idp', $idp);
            $sommeRecup->execute();
            $somme = $sommeRecup->fetchAll();
            // Recherche si le panier contient un article
            $reqSomme = $bdd->prepare("SELECT * FROM contenir WHERE idp = ?");
            $reqSomme->execute(array($idp));
            $sommeExist = $reqSomme->rowCount();
            if($sommeExist == 0)
            {
                echo "Votre panier est vide !";
            }
            else
            {
                echo "Le total du panier est de ".$somme[0][0]."€";
            }
        ?>
        </p>
        <a href="validationPanier.php">Valider mon panier</a>
        </main>
    </body>
    </html>
<?php
}
else
{
    header('Location: connexion.php');
}

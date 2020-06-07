<?php
session_start();
if($_SESSION['login'])
{
    include 'config.php';
    $bdd = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    $idp = $_SESSION['idp'];
    $reqStatut = $bdd->prepare("SELECT statut FROM paniercde WHERE idp = :idp");
    $reqStatut->bindParam(':idp', $idp);
    $reqStatut->execute();
    $nivStatut = $reqStatut->fetchAll();
    if($nivStatut[0][0] >= 1)
    {
?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="../style/global.css">
            <link rel="stylesheet" href="../style/validation_panier.css">
            <title>Validation du panier</title>
        </head>
        <body>
            <?php
                include '../includes/header.php';
            ?>
            <main>
            <form action="" method="post">
                <input type="submit" name="annuler" value="Annuler la commande">
                <input type="submit" name="valider" value="Valider">
            </form>
            <?php
                if(isset($_POST['annuler']))
                {
                    $statutCommandeAnnule = 0;
                    $panierAnnule = $bdd->prepare("UPDATE paniercde SET statut = :statut WHERE idp = :idp");
                    $panierAnnule->bindParam(':statut', $statutCommandeAnnule);
                    $panierAnnule->bindParam(':idp', $idp);
                    $panierAnnule->execute();
                    header('Location: panier.php');
                }
                if(isset($_POST['valider']))
                {
                    $statutPanierValide = 2;
                    $panierValide = $bdd->prepare("UPDATE paniercde SET statut = :statut WHERE idp = :idp");
                    $panierValide->bindParam(':statut', $statutPanierValide);
                    $panierValide->bindParam(':idp', $idp);
                    $panierValide->execute();
                    header("Refresh:0");
                }
                    if($nivStatut[0][0] == 1)
                    {
                        echo '<div id="nonVal" class="bleu"></div>';
                        echo '<div id="val" class="bleu"></div>';
                        echo '<div id="priseCompte"></div>';
                        echo '<div id="envoye"></div>';
                    }
                    elseif($nivStatut[0][0] == 2)
                    {
                        echo '<div id="nonVal" class="bleu"></div>';
                        echo '<div id="val" class="bleu"></div>';
                        echo '<div id="priseCompte" class="bleu"></div>';
                        echo '<div id="envoye"></div>';
                    }
                    elseif($nivStatut[0][0] == 3)
                    {
                        echo '<div id="nonVal" class="bleu"></div>';
                        echo '<div id="val" class="bleu"></div>';
                        echo '<div id="priseCompte" class="bleu"></div>';
                        echo '<div id="envoye" class="bleu"></div>';
                    }
                ?>
            </main>
        </body>
        </html>
<?php
    }
    else
    {
        header('Location: panier.php');
    }
}
else
{
    header('Location: connexion.php');
}
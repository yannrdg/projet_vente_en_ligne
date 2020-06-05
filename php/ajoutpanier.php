<?php
session_start();
if($_SESSION['login'])
{
    include 'config.php';
    $bdd = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    $ref = $_GET['ref'];
    $idp = $_SESSION['idp'];
    $reqRef = $bdd->prepare("SELECT * FROM contenir WHERE ref = ? AND idp = ?");
    $reqRef->execute(array($ref, $idp));
    $refExist = $reqRef->rowCount();
    if($refExist == 0)
    {  
        $reqProduit = $bdd->prepare("SELECT * FROM produit WHERE ref = :ref");
        $reqProduit->bindParam(':ref',$ref);
        $reqProduit->execute();
        $produit = $reqProduit->fetchAll();

        foreach($produit as $info):
        $idp = $_SESSION['idp'];
        $quantite = $_POST['quantite'];
        $prix = $info['prix'];
        $prixTotal = $info['prix'] * $quantite;

        
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Ajout</title>
        </head>
        <body>
            <h3>Voulez-vous ajoutez l'article au panier ?</h3>
            <form action="" method="post">
                <input type="submit" value="Oui" name="oui">
                <input type="submit" value="Non" name="non">
                <input type="number" name="quantite">
                    <p><?=$prix?></p>
            </form>
        </body>
        </html>
        <?php
        if(isset($_POST['oui']))
        {
            
            $ajout = $bdd->prepare("INSERT INTO contenir (idp, ref, quantite, prix, prixTotal) VALUES (:idp, :ref, :quantite, :prix, :prixTotal)");
            $ajout->bindParam(':idp', $idp);
            $ajout->bindParam(':ref', $ref);
            $ajout->bindParam(':quantite', $quantite);
            $ajout->bindParam(':prix', $prix);
            $ajout->bindParam(':prixTotal', $prixTotal);
            $ajout->execute();
            header('Location: panier.php');
        }
        elseif(isset($_POST['non']))
        {
            header('Location: ../index.php');
        }
        endforeach;
    }
    else
    {
        echo "Vous avez déjà ajoutez cette article";
    }
}
else
{
    header('Location: connexion.php');
}

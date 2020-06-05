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
            </form>
        </body>
        </html>
        <?php
        if(isset($_POST['oui']))
        {
            $reqProduit = $bdd->prepare("SELECT * FROM produit WHERE ref = :ref");
            $reqProduit->bindParam(':ref',$ref);
            $reqProduit->execute();
            $produit = $reqProduit->fetchAll();
            
            $idp = $_SESSION['idp'];
            $quantite = $_POST['quantite'];
            
            $ajout = $bdd->prepare("INSERT INTO contenir (idp, ref, quantite) VALUES (:idp, :ref, :quantite)");
            $ajout->bindParam(':idp', $idp);
            $ajout->bindParam(':ref', $ref);
            $ajout->bindParam(':quantite', $quantite);
            $ajout->execute();
            header('Location: panier.php');
        }
        elseif(isset($_POST['non']))
        {
            header('Location: ../index.php');
        }
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

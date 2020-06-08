<?php
session_start();
include 'php/config.php';
$bdd = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);

//Création d'un compteur. Si l'utilisateur est connecté, l'id de la page que j'ai choisi, s'ajoute avec son login dans la table 'visiter'
if(isset($_SESSION['login']))
{
    $login = $_SESSION['login'];
    $idpage = 0;
    $compteur = $bdd->prepare("INSERT INTO visiter (login, idpage) VALUES (:login, :idpage)");
    $compteur->bindParam(':login', $login);
    $compteur->bindParam(':idpage', $idpage);
    $compteur->execute();
}
$info = $bdd->prepare("SELECT * FROM produit ORDER BY date DESC");
$exec = $info->execute();
$produit = $info->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="yann" content="auhtor">
    <link rel="stylesheet" href="style/global.css">
    <link rel="stylesheet" href="style/produit.css">
    <title>Acceuil</title>
</head>

<body>
    <header>
        <a href="index.php" id="logo"><img src="medias/Select_logo.png" alt="logo Select"></a>
        <div>
            <form action="" method="post">
                <input type="text" name="recherche" placeholder="Que recherchez-vous ?">
                <input type="submit" name="demande" value="&#128269;">
                <?php
                    if(isset($_POST['demande']))
                    {
                        //Gestion de la barre de recherche
                        $submit = $_POST['demande'];
                        $texte = $_POST['recherche'];
                        $recherche = $bdd->prepare("SELECT * FROM produit WHERE nom LIKE :texte ORDER BY date DESC");
                        $recherche->bindValue(":texte",'%'.$texte.'%');
                        $execute = $recherche->execute();
                        $produit = $recherche->fetchAll();
                    }
                ?>
            </form>
        </div>
        <?php
            if(isset($_SESSION['login']))
            {
        ?>
        <nav id="deroulant">
            <a>Mon profil</a>
            <ul>
                <li><a id="profil" href="php/profil.php">Gérer mon profil</a></li>
                <?php
                if($_SESSION['login'] == 'admin')
                {
            ?>
                <li><a id="admin" href="php/admin.php">Page administration</a></li>
                <?php
                }
            ?>
                <li><a id="deco" href="php/deconnexion.php">Deconnectez-vous</a></li>
            </ul>
        </nav>
        <a id="panier" href="php/panier.php">Mon panier</a>

        <?php
            }
            else
            {
        ?>
        <a href="php/connexion.php">Identifiez-vous</a>
        <a href="php/inscription.php">Rejoignez-nous</a>
        <?php                
            }
        ?>
        <nav id="categories">
            <ul>
                <li><a href="php/femme.php">Femme</a></li>
                <li><a href="php/homme.php">Homme</a></li>
                <li><a href="php/ballon.php">Ballon</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <?php foreach ($produit as $items): ?>
        <section class="<?= $items['type']?>">
            <h3><?= $items['nom']?></h3>
            <p><?= $items['descriptif']?></p>
            <img src="medias/<?= $items['ref']?>.jpg" alt="image">
            <p>Référence : <?= $items['ref']?></p>
            <a href="php/ajoutpanier.php?ref=<?= $items['ref']?>">Ajouter au panier</a>
        </section>
        <?php endforeach; ?>

    </main>
</body>

</html>
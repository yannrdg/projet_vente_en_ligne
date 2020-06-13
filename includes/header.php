<!-- Fichier de regroupement du header -->
<header>
    <a href="../index.php" id="logo"><img src="../medias/Select_logo.png" alt="logo Select"></a>
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
            <li><a id="profil" href="profil.php">Gérer mon profil</a></li>
            <?php
                if($_SESSION['login'] == 'admin')
                {
            ?>
            <li><a id="admin" href="admin.php">Page administration</a></li>
            <?php
                }
            ?>
            <li><a id="deco" href="deconnexion.php">Deconnectez-vous</a></li>
        </ul>
    </nav>
    <?php
            <a id="panier" href="panier.php"><img src="../medias/panier.png" alt="panier"></a>
            }
            else
            {
        ?>
    <a href="connexion.php">Identifiez-vous</a>
    <a href="inscription.php">Rejoignez-nous</a>
    <?php                
            }
        ?>
    <nav id="categories">
        <ul>
            <li><a href="femme.php">Femme</a></li>
            <li><a href="homme.php">Homme</a></li>
            <li><a href="ballon.php">Ballon</a></li>
        </ul>
    </nav>
</header>
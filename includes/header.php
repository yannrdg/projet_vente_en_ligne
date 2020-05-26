<!-- Fichier de regroupement du header -->
<header>
    <a href="../index.php" id="logo"><img src="../medias/Select_logo.png" alt="logo Select"></a>
    <div>
        <input type="text" name="recherche" placeholder="Que recherchez-vous ?">
        <input type="submit" name="demande" value="&#128269;">
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
    <a id="panier" href="panier.php">Mon panier</a>
    <?php
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
            <li><a href="football.php">Football</a></li>
            <li><a href="handball.php">Handball</a></li>
            <li><a href="textile.php">Textile</a></li>
            <li><a href="ballon.php">Ballon</a></li>
        </ul>
    </nav>
</header>
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
</header>
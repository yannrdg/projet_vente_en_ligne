<header>
        <a href="../index.php" id="logo"><img src="../medias/Select_logo.png" alt="logo Select"></a>
        <div>
            <input type="search" name="recherche" placeholder="Que recherchez-vous ?">
            <input type="submit" name="demande" value="&#128269;">
        </div>
        <?php
            if(isset($_SESSION['login']))
            {
        ?>
                <a href="deconnexion.php">Deconnectez-vous</a>
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
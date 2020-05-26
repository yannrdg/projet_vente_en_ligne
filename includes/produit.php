<!-- Fichier de regroupement des sections de produit -->
<section class="<?= $items['type']?>">
                <h3><?= $items['nom']?></h3>
                <p><?= $items['descriptif']?></p>
            <img src="../medias/<?= $items['ref']?>.jpg" alt="image">
            <p>Référence : <?= $items['ref']?></p>
            <a href="ajoutpanier.php?ref=<?= $items['ref']?>">Ajouter au panier</a>
</section>

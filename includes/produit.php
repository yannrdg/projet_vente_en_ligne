<section class="<?= $items['type']?>">
                <h3><?= $items['nom']?></h3>
                <p><?= $items['descriptif']?></p>
            <img src="../medias/<?= $items['ref']?>.jpg" alt="image">
            <p>Référence : <?= $items['ref']?></p>
            <input type="submit" name="panier" value="Ajouter au panier">
</section>
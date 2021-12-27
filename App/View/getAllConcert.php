<?php

//var_dump($content);

?>

                                    <!-- ==============================
                                            SUGGESTION COOKIES
                                    =============================== -->


<?php if (isset($_COOKIE)) : ?>
    <?php if (!empty($_COOKIE['genre']) && $_COOKIE['genre'] == 'all') : ?>
        <p id="info_cookie"> Parce que vous avez regardé tous les genres </p>
    <?php elseif (!empty($_COOKIE['genre']) && $_COOKIE['genre'] != 'all') : ?>
        <p id="info_cookie"> Parce que vous avez regardé <?= $content[0]['nomGenre'] ?> </p>
    <?php endif; ?>
<?php endif; ?>

                                    <!-- ================================
                                         AFFICHAGE DES CONCERT DE LA PAGE
                                         ================================ -->


<h2 id="titre"> Réservez votre place pour voir vos artistes <br> préférés ! </h2>

<section id="affGroupe">
    <ul id="list_group">
        <?php foreach ($content as $unConcert): ?>
            <li class="group">
                <img src="<?= $unConcert['image']; ?>" alt="<?= $unConcert['nom']; ?>">
                <p> Nom : <?= $unConcert['nom']; ?> </p>
                <p> Lieu : <?= $unConcert['lieu']; ?> </p>
                <p> Prix : <?= $unConcert['prix_place']; ?> € </p>
                <a href="index.php?nom=<?= $unConcert['nom']; ?>&id=<?= $unConcert['id_concert'];?>" class="lien-details"> Voir les détails</a>
            </li>
        <?php endforeach; ?>
    </ul>
</section>

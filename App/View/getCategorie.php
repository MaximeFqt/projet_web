<?php

//var_dump($content);

if (isset($_POST['sendSelectGenre']) && isset($_POST['selectGenre']) && !empty($_POST['selectGenre'])) {
    $genre = htmlspecialchars($_POST['selectGenre']);
    //Redirection
    header("location: index.php?cat=$genre");
}

if (isset($_GET['cat'])) {
    $cat = htmlspecialchars($_GET['cat']);

    /* ***** COOKIE ***** */
    $name = 'genre';    // nom
    $value = $cat;      // id_genre
    // variable uniquement pour la session
    setcookie($name, $cat);
}

?>

<section id="affGroupe">

    <ul id="list_group">
        <?php foreach ($content as $unConcert): ?>
            <li class="group">
                <img src="<?= $unConcert['image']; ?>" alt="<?= $unConcert['nom']; ?>">
                <p> Nom : <?= $unConcert['nom']; ?> </p>
                <p> Lieu : <?= $unConcert['lieu']; ?> </p>
                <p> Prix : <?= $unConcert['prixPlace']; ?> € </p>
                <a href="../../index.php?nom=<?= $unConcert['nom']; ?>&id=<?= $unConcert['idConcert'];?>" class="lien-details"> Voir les détails </a>
            </li>
        <?php endforeach; ?>
    </ul>
</section>

<p class="retourIndex">
    <a href="../../index.php"> Retour </a>
</p>

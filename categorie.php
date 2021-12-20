<?php
session_start();

include('connexion.php');
$connexion = connexionBd();

if (isset($_POST['sendSelectGenre']) && isset($_POST['selectGenre']) && !empty($_POST['selectGenre'])) {

    $genre = htmlspecialchars($_POST['selectGenre']);
    //Redirection
    header("location: categorie.php?cat=$genre");

}

if (isset($_GET['cat'])) {
    $cat = htmlspecialchars($_GET['cat']);

    /* ***** COOKIE ***** */
    $name = 'genre';    // nom
    $value = $cat;      // id_genre
    // variable uniquement pour la session
    setcookie($name, $cat);

    if ($cat === 'all') {
        // Requête
        $sql = "select * from concerts C join groupes Gr on Gr.id_groupe = C.groupe;";
        // Envoie
        $concerts = $connexion->query($sql);
        // Traitement
        $concert = $concerts->fetchAll(PDO::FETCH_OBJ);
    } else {
        // Requête
        $sql2 = "select * from concerts C join groupes Gr on Gr.id_groupe = C.groupe where Gr.genre = '$cat';";
        // Envoie
        $concerts = $connexion->query($sql2);

        if ($concerts->rowCount() > 0) {
            // Traitement
            $concert = $concerts->fetchAll(PDO::FETCH_OBJ);
        } else {
            setcookie($name);
            header('location: index.php');
        }

    }

}

?>

<!doctype html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="css/reset.css" rel="stylesheet" type="text/css">
        <link href="css/layout.css" rel="stylesheet" type="text/css">
        <link href="css/color.css" rel="stylesheet" type="text/css">
        <script src="js/comportement.js"></script>
        <title> Concertôt </title>
    </head>
    <body>

        <?php include('header.php'); ?>

        <section id="affGroupe">

            <ul id="list_group">
                <?php foreach ($concert as $unConcert): ?>
                    <li class="group">
                        <img src="<?= $unConcert->image; ?>" alt="<?= $unConcert->nom; ?>">
                        <p> Nom : <?= $unConcert->nom; ?> </p>
                        <p> Lieu : <?= $unConcert->lieu; ?> </p>
                        <p> Prix : <?= $unConcert->prix_place; ?>€ </p>
                        <a href="vue_concert.php?nom=<?= $unConcert->nom; ?>" class="lien-details"> Voir les détails</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>

        <p class="retourIndex">
            <a href="index.php"> Retour </a>
        </p>

        <?php include('footer.php'); ?>

    </body>
</html>

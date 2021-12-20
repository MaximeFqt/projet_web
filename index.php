<?php
session_start();

if (isset($_SESSION['login']) && isset($_SESSION['pass']) && isset($_SESSION['role']) ) {
    $login = $_SESSION['login'];
    $pass = $_SESSION['pass'];
    $role = $_SESSION['role'];
}

// Inclusion du fichier
include('connexion.php');
// Appel de la méthode permettant la connexion à la BDD
$connexion = connexionBd();

if (isset($_COOKIE['genre'])) {
    $genre = $_COOKIE['genre'];

    if ($genre == 'all') {
        // Requete SQL récupérant 3 article au hasard
        $sql = "select * from concerts C join groupes G on G.id_groupe = C.groupe order by rand() limit 3;";
    } else {
        // Requete SQL récupérant 3 article au hasard
        $sql = "select * from concerts C join groupes G on G.id_groupe = C.groupe join genremusical Gm on Gm.id_genre = G.genre
        where G.genre = '$genre' order by rand() limit 3;";
    }
} else {
    // Requete SQL récupérant 3 articles au hasard
    $sql = "select * from concerts C join groupes G on G.id_groupe = C.groupe order by rand() limit 3;";
}

$recupAdmin = "select * from users;";

$concerts = $connexion->query($sql);                    // Envoie
$concert = $concerts->fetchAll(PDO::FETCH_OBJ);   // Traitement

$users = $connexion->query($recupAdmin);               // Envoie
$user = $users->fetchAll(PDO::FETCH_OBJ);       // Traitement

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
        <title>Concertôt</title>
    </head>

    <body id="body">
        <?php require("header.php");?>



        <!-- ===============================
                INFORMATIONS DE CONNEXION
             =============================== -->


        <?php if (isset($role)) : ?>
            <?php if ($role == 'admin') : ?>
                <p id="info_connection"> Vous êtes connecté en tant qu'administrateur </p>
            <?php else : ?>
                <p id="info_connection"> Vous êtes connecté en tant que : <?= $login; ?> </p>
            <?php endif; ?>
        <?php else : ?>
            <p id="info_connection"> Vous n'êtes pas connecté </p>
        <?php endif; ?>


        <!-- ===============================
                   SUGGESTION COOKIES
             =============================== -->


        <?php if (isset($_COOKIE)) : ?>
            <?php if (!empty($_COOKIE['genre']) && $_COOKIE['genre'] == 'all') : ?>
                <p id="info_cookie"> Parce que vous avez regardé tous les genres </p>
            <?php elseif (!empty($_COOKIE['genre']) && $_COOKIE['genre'] != 'all') : ?>
                <p id="info_cookie"> Parce que vous avez regardé <?= $concert[0]->nomGenre; ?> </p>
            <?php endif; ?>
        <?php endif; ?>

        <!-- ===============================
                 FORMULAIRE DE CONNEXION
             =============================== -->


        <form id="formulaire" method="post" action="login.php">
            <fieldset id="form-login">
                <legend>Identification administrateur</legend>
                <p>
                    <label for="identifiant">Identifiant: </label>
                    <input type="text" placeholder="identifiant" name="login" autocomplete="off" id="identifiant" required/>
                </p>
                <p>
                    <label for="motDePasse">Mot de passe:</label>
                    <input type="password" placeholder="Mot de passe" name="pass" id="motDePasse" required/>
                </p>
                <p>
                    <a href="ajoutUser.php" class="inscription"> Je m'inscrit </a>
                </p>
            </fieldset>
            <p class="submit">
                <input type="submit" id="btnSubmit" value="Continuer" name="send"/>
                <input type="reset" id="btnReset" value="Annuler" />
            </p>
        </form>



        <!-- ===============================
             AFFICHAGE DES CONCERT DE LA PAGE
             =============================== -->


        <h2 id="titre"> Réservez votre place pour voir vos artistes <br> préférés ! </h2>

        <section id="affGroupe">
            <ul id="list_group">
                <?php foreach ($concert as $unConcert): ?>
                    <li class="group">
                        <img src="<?= $unConcert->image; ?>" alt="<?= $unConcert->nom; ?>">
                        <p> Nom : <?= $unConcert->nom; ?> </p>
                        <p> Lieu : <?= $unConcert->lieu; ?> </p>
                        <p> Prix : <?= $unConcert->prix_place; ?>€ </p>
                        <a href="vue_concert.php?nom=<?= $unConcert->nom; ?>&id=<?= $unConcert->id_concert;?>" class="lien-details"> Voir les détails</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>

        <?php require("footer.php");?>
    </body>
</html>

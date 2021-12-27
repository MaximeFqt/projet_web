<?php
session_start();

// Utilisation du fichier
use App\Config\Database;
use App\Controller\ControllerConcerts;
use App\Controller\ControllerGenreMusical;

/* AUTOLOAD */
//autoload
function chargerClasse($classe)
{
    $classe = str_replace('\\','/',$classe);
    require $classe . '.php';
}
spl_autoload_register('chargerClasse'); //fin Autoload

// Instanciation d'une bdd
$db = new Database();
$connexion = $db->getConnection();

$controllerConcert = new ControllerConcerts();
$controllerGenre   = new ControllerGenreMusical();

/* PROCEDURAL */

if (isset($_SESSION['login']) && isset($_SESSION['pass']) && isset($_SESSION['role']) ) {
    $login = $_SESSION['login'];
    $pass = $_SESSION['pass'];
    $role = $_SESSION['role'];
}

$recupAdmin = "select * from users;";

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
        <title> Concertôt </title>
    </head>

    <body id="body">
        <?php require("utils/header.php");?>


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
                <input type="submit" id="btnSubmitLogin" value="Continuer" name="send"/>
                <input type="reset" id="btnResetLogin" value="Annuler" />
            </p>
        </form>


        <?php
            if (isset($_GET['nom']) && isset($_GET['id'])) {

                // Affichage d'un seul concert
                $controllerConcert->getOne();

            } else if (isset($_GET['cat']) && !empty($_GET['cat'])) {

                // Affichage de tous les concerts en fonction du genre choisi
                $controllerConcert->getCategorie( $_GET['cat'] );

            } else if (isset($_POST['selectGenre']) && !empty($_POST['selectGenre'])) {

                // Affichage de tous les concerts en fonction du genre choisi
                $controllerConcert->getCategorie( $_POST['selectGenre'] );

            } else if (!isset($_COOKIE['genre']) || $_COOKIE['genre'] == 'all') {

                // Affichage de tous les concerts en fonction du cookie
                $controllerConcert->getAll();

            } else {

                $controllerGenre->getGenre( $_COOKIE['genre'] );

            }
        ?>

        <?php require("utils/footer.php");?>
    </body>
</html>

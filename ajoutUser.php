<?php

// Démarrage de la session
session_start();
// Inclusion du fichier de connexion à la base de donnée
include('connexion.php');

if (isset($_POST['send'])) {
    $login  = htmlspecialchars($_POST['login']);
    $pass = htmlspecialchars($_POST['pass']);
    $email = htmlspecialchars($_POST['email']);

    // Connexion à la base
    $connexion = connexionBd();

    // Requête vérification login
    $sqlLogin = "select * from users where login = '$login';";
    $usersLogin = $connexion->query($sqlLogin);

    if ($usersLogin->rowCount() > 0) {
        // Redirection
        echo '<meta http-equiv="refresh" content="0;URL=ajoutUser.php">';
        // Affichage de l'alerte (font de la page est la page ajoutUser.php)
        echo '<body onload = "alert(\'Cet identifiant nest pas disponible\')" >';

    } else {
        // Hachage du mot de passe
        $pass = password_hash($pass, PASSWORD_DEFAULT);

        // Requête sql
        $sqlInsertUser = "insert into users (login, pass, email) values ('$login', '$pass', '$email');";
        $newUser = $connexion->exec($sqlInsertUser);             // Envoie

        $_SESSION['login'] = $_POST['login'];
        $_SESSION['pass'] = $_POST['pass'];
        $_SESSION['role'] = 'user';

        header('location: index.php');
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
        <script src="js/formulaireInscription.js"></script>
        <title>TrouvesTonConcert</title>
    </head>
    <body>
        <?php include('header.php'); ?>

        <h1> Vous n'êtes pas enregistré parmis les utilisaterus de notre site </h1>
        <h2> Souhaitez-vous vous enregistrer ? </h2>

        <!-- ===============================
             FORMULAIRE D'INSCRIPION AU SITE
             =============================== -->

        <form id="formulaire-enregistrement" method="post" action="ajoutUser.php">
            <fieldset>
                <legend> Enregistrement des informations </legend>
                <p>
                    <label for="identifiant"> * Identifiant : </label>
                    <input type="text" placeholder="Identifiant" id="id_new_user" name="login" autocomplete="off" required/>
                </p>
                <p>
                    <label for="email"> * Email : </label>
                    <input type="email" placeholder="ex@emple.fr" id="email_new_user" name="email" autocomplete="off"/>
                </p>
                <p>
                    <label for="mot de passe"> * Mot de passe : </label>
                    <input type="password" placeholder="Mot de passe" id="pass_new_user" name="pass" required>
                </p>
                <p>
                    <label for="confirmation"> * Confirmation : </label>
                    <input type="password" placeholder="Confirmation" id="pass_confirm_new_user" required>
                </p>
                <p> * Champs obligatoires</p>
                <p id="infoFormulaireUser"></p>
            </fieldset>
            <p class="submit">
                <input type="button" id="btnSubmit_ajout" value="Continuer" name="send"/>
                <input type="reset" id="btnReset_ajout" value="Annuler" />
            </p>
            <p class="retourIndex">
                <a href="index.php"> Retour </a>
            </p>
        </form>

        <?php include('footer.php'); ?>
    </body>
</html>

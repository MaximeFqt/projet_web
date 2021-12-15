<?php

session_start();

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
        <title>TrouvesTonConcert</title>
    </head>
    <body>

        <?php include('header.php'); ?>

        <?php if (!isset($_SESSION['login'])) : ?>
            <h2 id="titre"> Connectez-vous pour avoir accès à votre panier </h2>
        <?php else : ?>
            <h2 id="titre"> Voici votre panier </h2>
        <?php endif; ?>


        <!-- ===============================
                 FORMULAIRE DE CONNEXION
             =============================== -->


        <form id="formulaire" method="post" action="login.php">
            <fieldset id="form-login">
                <legend>Identification administrateur</legend>
                <p>
                    <label for="identifiant">Identifiant: </label>
                    <input type="text" placeholder="identifiant" name="login" autocomplete="off" required/>
                </p>
                <p>
                    <label for="motDePasse">Mot de passe:</label>
                    <input type="password" placeholder="Mot de passe" name="pass" required/>
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


        <!--
        Pouvoir indiquer si le panier est vide et pouvoir ajouter des concerts
        -->

        <?php include('footer.php'); ?>

    </body>
</html>

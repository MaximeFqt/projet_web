<?php

/*
 * FICHIER PERMETTANT L'IDENTIFICATION DE L'UTILISATEUR
 */

// Inclusion de fichier
include('connexion.php');

if (isset($_POST['send'])) {

    $login = htmlspecialchars($_POST['login']);
    $pass = htmlspecialchars($_POST['pass']);

    // Connexion à la base
    $connexion = connexionBd();

    // Requête sql
    $sqlUser = "select * from users where login = '$login'";
    $users = $connexion->query($sqlUser);             // Envoie

    if ($users->rowCount() > 0) {
        $user = $users->fetchAll(PDO::FETCH_ASSOC);    // Traitement
        if (password_verify($pass, $user[0]['pass'])) {
            // Démarrage de la session
            session_start();
            $_SESSION['login'] = $_POST['login'];
            $_SESSION['pass'] = $_POST['pass'];

            if ($login == 'admin' && $pass = 'admin') {
                $_SESSION['role'] = 'admin';
            } else {
                $_SESSION['role'] = 'user';
            }

            header('location: index.php');
        } else {
            // Alerte
            echo '<body onload = "alert(\'Les informations de connexion sont incorrectes\')" >';
            // Redirection
            echo '<meta http-equiv="refresh" content="0;URL=index.php">';
        }
    } else {
        // Alerte
        echo '<body onload = "alert(\'Les informations de connexion sont incorrectes\')" >';
        // Redirection
        echo '<meta http-equiv="refresh" content="0;URL=index.php">';
    }

}
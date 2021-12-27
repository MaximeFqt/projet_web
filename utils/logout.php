<?php

/*
 * FICHIER PERMETTANT LA DESTRUCTION DE LA SESSION DE L'UTILISATEUR
 */

session_start();

// Destruction des variables de session
session_unset();

// Destruction de la session en cours
session_destroy();

// Redirection vers la page d'accueil
header('location: index.php');
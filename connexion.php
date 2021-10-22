<?php

// Connexion à une base de donnée
function connexionBd($SERVEUR = "localhost", $USER = "root",
                     $MDP = "", $BD = "projet_web") {

    // gestion de la connexion
    try  {
        $connexion = new PDO('mysql:host='.$SERVEUR.';dbname='.$BD, $USER, $MDP);
        $connexion->exec("SET CHARACTER SET utf8");     //Gestion des accents
    }
        //gestion des erreurs
    catch(Exception $e) {
        echo 'Erreur : '.$e->getMessage().'<br />';
        echo 'N° : '.$e->getCode();
    }
    return $connexion;
}

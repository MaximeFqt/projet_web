<?php

/*
 * FICHIER PERMETTANT L'IDENTIFICATION DE L'UTILISATEUR
 */

// Utilisation du fichier
use App\Config\Database;

/* AUTOLOAD */
//autoload
function chargerClasse($classe)
{
    $classe=str_replace('\\','/',$classe);
    require $classe . '.php';
}
spl_autoload_register('chargerClasse'); //fin Autoload

// Instanciation d'une bdd
$db = new Database();

if (isset($_POST['send'])) {

    $login = htmlspecialchars($_POST['login']);
    $pass = htmlspecialchars($_POST['pass']);

    // Connexion à la base
    $connexion = $db->getConnection();

    // Requête sql
    $sqlUser = "select * from users where login = '$login'";
    $users = $connexion->query($sqlUser);             // Envoie

    if ($users->rowCount() > 0) {
        $user = $users->fetchAll(PDO::FETCH_ASSOC);    // Traitement
        if (password_verify($pass, $user[0]['pass'])) {
            // Démarrage de la session
            session_start();
            $_SESSION['login'] = $_POST['login'];
            $_SESSION['pass']  = $user[0]['pass'];
            $_SESSION['id']    = $user[0]['id_user'];

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
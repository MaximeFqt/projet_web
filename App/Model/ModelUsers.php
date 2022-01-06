<?php

namespace App\Model;

use App\Entity\Users;

class ModelUsers extends Model
{

    public function __construct()
    {
        $this->table = "users";
        parent::__construct($this->table);
    }

    public function findAll(): array
    {
        $user = $this->find();
        $users = array();

        foreach ($user as $unUser) {
            $unUser = new Users(
                array(
                    "idUser" => $unUser['idUser'],
                    "login"  => $unUser['login'],
                    "pass"   => $unUser['pass'],
                    "email"  => $unUser['email']
                )
            );
            array_push($users, $unUser);
        }

        return $users;
    }

    // Trouve l'utilisateur par rapport à son login
    public function findByParam($login): array
    {
        $users = array();

        $sql = "select * from $this->table where login = '$login';";
        $user = $this->getConnexion()->query($sql);

        if ($user->rowCount() === 1) {
            foreach ($user as $unUser) {
                array_push($users, $unUser);
            }
        }
        return $users;
    }

    // Connexion
    public function login()
    {
        if ($_POST) {
            $login = htmlspecialchars($_POST['login']);
            $pass  = htmlspecialchars($_POST['pass']);

            $userData = $this->findByParam($login);
            if ($userData != array()) {
                $user = new Users($userData[0]);
                if (password_verify($pass, $user->getPass())) {

                    session_start();

                    $getUser = $this->findByParam($login);

                    $_SESSION['login']  = $getUser[0]['login'];
                    $_SESSION['pass']   = $getUser[0]['pass'];
                    $_SESSION['idUser'] = $getUser[0]['idUser'];

                    if ($_POST['login'] == "admin") {
                        $_SESSION['role'] = "admin";
                    } else {
                        $_SESSION['role'] = "user";
                    }

                    header('location: index.php');

                } else {
                    // Redirection
                    echo '<meta http-equiv="refresh" content="0;URL=index.php">';
                    // Message d'erreur
                    echo '<body onload = "alert(\'Mot de passe incorrect !\')" >';
                }
            } else {
                // Redirection
                echo '<meta http-equiv="refresh" content="0;URL=index.php">';
                // Message d'erreur
                echo '<body onload = "alert(\'Compte inconnu !\')" >';
            }
        } else {
            // Redirection
            echo '<meta http-equiv="refresh" content="0;URL=index.php">';
            // Message d'erreur
            echo '<body onload = "alert(\'Une erreur est survenue !\')" >';
        }
    }

    // Déconnexion
    public function logout(): bool
    {
        session_start();
        // Destruction des variables de session
        session_unset();
        // Destruction de la session en cours
        session_destroy();
        return true;
    }

    // Aout d'un utilisateur
    public function addUser()
    {
        if ($_POST) {
            $login = htmlspecialchars($_POST['login']);
            $pass  = htmlspecialchars($_POST['pass']);
            $email = htmlspecialchars($_POST['email']);

            $userData = $this->findByParam($login);
            if (empty($userData)) {
                $pass = password_hash($pass, PASSWORD_DEFAULT);

                $data = array(
                    "login" => $login,
                    "pass"  => $pass,
                    "email" => $email
                );

                $user = new Users($data);

                $insertUser = $this->create($data);
                $getUser = $this->findByParam($login);

                session_start();

                $_SESSION['login']  = $getUser[0]['login'];
                $_SESSION['pass']   = $getUser[0]['pass'];
                $_SESSION['idUser'] = $getUser[0]['idUser'];
                $_SESSION['role']   = "user";

                header('location: index.php');

            } else {
                // Redirection
                echo '<meta http-equiv="refresh" content="0;URL=index.php">';
                // Message d'erreur
                echo '<body onload = "alert(\'Ce login est déjà pris !\')" >';
            }
        } else {
            // Redirection
            echo '<meta http-equiv="refresh" content="0;URL=index.php">';
            // Message d'erreur
            echo '<body onload = "alert(\'Une erreur est survenue !\')" >';
        }
    }


}
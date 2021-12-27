<?php

namespace App\Controller;

use App\Entity\Users;
use App\Model\ModelUsers;
use App\Model\Model;

class ControllerUsers
{

    private Model $model;
    //private $view;

    public function __construct()
    {
        $this->model = new ModelUsers();
        //$this->view = new View();
    }

    // Connection de l'utilisateur
    public function login()
    {
        if ($_POST) {
            $login = htmlspecialchars($_POST['login']);
            $pass  = htmlspecialchars($_POST['pass']);

            $userData = $this->model->findByParam($login);
            if ($userData != array()) {
                $user = new Users($userData[0]);
                if (password_verify($pass, $user->getPass())) {

                    session_start();

                    $getUser = $this->model->findByParam($login);

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

    public function addUser()
    {
        if ($_POST) {
            $login = htmlspecialchars($_POST['login']);
            $pass  = htmlspecialchars($_POST['pass']);
            $email = htmlspecialchars($_POST['email']);

            $userData = $this->model->findByParam($login);
            if (empty($userData)) {
                $pass = password_hash($pass, PASSWORD_DEFAULT);

                $data = array(
                    "login" => $login,
                    "pass"  => $pass,
                    "email" => $email
                );

                $user = new Users($data);

                $insertUser = $this->model->create($data);
                $getUser = $this->model->findByParam($login);

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
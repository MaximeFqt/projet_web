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

    public function getAll()
    {
        $content = $this->model->findAll();

        include('App/View/getAllUsers.php');
    }

    // Connection de l'utilisateur
    public function login()
    {
        $login = $this->model->login();

    }

    // Ajouter un utilisateur
    public function addUser()
    {
        $addUser = $this->model->addUser();
    }

    // Déconnexion
    public function logout()
    {
        $logout = $this->model->logout();
        header('location: index.php');
    }

    // Include view
    public function getView()
    {
        include('App/View/viewAjoutUser.php');
    }

    // Include view Admin
    public function getViewAdmin()
    {
        include('App/View/viewAdmin.php');
    }

}
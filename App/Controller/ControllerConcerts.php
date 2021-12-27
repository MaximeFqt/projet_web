<?php

namespace App\Controller;

use App\Model\Model;
use App\Model\ModelConcerts;

class ControllerConcerts
{

    private Model $model;
    //private $view;

    public function __construct()
    {
        $this->model = new ModelConcerts();
        //$this->view = new View();
    }

    // Récupérer tous les concerts
    public function getAll()
    {
        $content = $this->model->findAll();

        include('App/View/getAllConcert.php');
    }

    // Récupérer un seul concert
    public function getOne()
    {
        if (isset($_GET['nom']) && !empty($_GET['nom']) && isset($_GET['id']) && !empty($_GET['id'])) {
            $nom = $_GET['nom'];
            $id = $_GET['id'];
        }
        $content = $this->model->findOne($id, $nom);

        include('App/View/getOneConcert.php');
    }

    public function getCategorie($id)
    {
        $content = $this->model->findOneCategorie($id);

        include('App/View/getCategorie.php');
    }

}
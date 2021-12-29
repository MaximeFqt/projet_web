<?php

namespace App\Controller;

use App\Model\Model;
use App\Model\ModelGroupes;

class ControllerGroupes
{

    private Model $model;
    //private $view;

    public function __construct()
    {
        $this->model = new Modelgroupes();
        //$this->view = new View();
    }

    // Récupérer tous les concerts
    public function getAll()
    {
        $content = $this->model->findAll();

        include('App/View/getAllGroupes.php');
    }

}
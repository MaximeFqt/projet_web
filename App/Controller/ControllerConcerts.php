<?php

namespace App\Controller;

use App\Model\Model;
use App\Model\ModelConcerts;

class ControllerConcerts
{

    private Model  $model;
    private String $view;

    public function __construct()
    {
        $this->model = new ModelConcerts();
        //$this->view = new View();
    }

    // Récupérer tous les concerts
    public function getAll()
    {
        $content = $this->model->findAll();

        include('App/View/getAllConcerts.php');
    }

    // Récupérer trois concerts
    public function getThree()
    {
        $content = $this->model->findThree();

        include('App/View/getThreeConcert.php');
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

    // Affiche tous les concerts d'une même catégorie
    public function getCategorie($id)
    {
        $content = $this->model->findOneCategorie($id);

        include('App/View/getCategorie.php');
    }

    // Ajoute un concert dans la BDD
    public function addConcert(array $data)
    {
        $content = $this->model->insertConcert($data);
        echo '<meta http-equiv="refresh" content="0;URL=index.php?admin=true">';
    }

    // Supprimer un concert
    public function deleteConcert(array $data)
    {
        $content = $this->model->deleteConcert($data);
        echo '<meta http-equiv="refresh" content="0;URL=index.php?admin=true">';
    }

    // Récupération d'un concert
    public function getSelectConcert(array $data)
    {
        $content = $this->model->findSelectConcert($data);
        if ($content) {
            echo '<meta http-equiv="refresh" content="0;URL=index.php?admin=true&modifConcert=true">';
        } else {
            echo '<meta http-equiv="refresh" content="0;URL=index.php?admin=true">';
        }
    }

    // Modification d'un concert
    public function updateConcert(array $dataSession, array $dataPOST)
    {
        $content = $this->model->updateConcert($dataSession, $dataPOST);
        echo '<meta http-equiv="refresh" content="0;URL=index.php?admin=true">';
    }

}
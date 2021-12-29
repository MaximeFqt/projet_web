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

    // Ajoute un groupe dans la BDD
    public function addGroupe(array $data)
    {
        $content = $this->model->insertGroupe($data);
        echo '<meta http-equiv="refresh" content="0;URL=index.php?admin=true">';
    }

    // Supprimer un groupe
    public function deleteGroupe(array $data)
    {
        $content = $this->model->deleteGroupe($data);
        echo '<meta http-equiv="refresh" content="0;URL=index.php?admin=true">';
    }

    // Sélection du groupe
    public function getSelectGroupe(array $data)
    {
        $content = $this->model->findSelectGroupe($data);
        if ($content) {
            echo '<meta http-equiv="refresh" content="0;URL=index.php?admin=true&modifGroupe=true">';
        } else {
            echo '<meta http-equiv="refresh" content="0;URL=index.php?admin=true">';
        }
    }

    // Modification du groupe sélectionné
    public function updateGroupe(array $dataSession, array $dataPOST)
    {
        $content = $this->model->updateGroupe($dataSession, $dataPOST);
        echo '<meta http-equiv="refresh" content="0;URL=index.php?admin=true">';
    }

}
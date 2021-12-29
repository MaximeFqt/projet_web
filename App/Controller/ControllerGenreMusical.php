<?php

namespace App\Controller;

use App\Model\Model;
use App\Model\ModelGenreMusical;

class ControllerGenreMusical
{

    private Model $model;
    //private $view;

    public function __construct()
    {
        $this->model = new ModelGenreMusical();
        //$this->view = new View();
    }

    // Récupérer tous les genres
    public function getAll()
    {
        $content = $this->model->findAll();

        include('App/View/getAllGenres.php');
    }

    // Récupérer un seul genre
    public function getGenre($genre)
    {
        $content = $this->model->findGenre($genre);

        include('App/View/getConcertsByGenre.php');
    }

    // Ajoute un groupe dans la BDD
    public function addGenre(String $nomGenre)
    {
        $content = $this->model->insertGenre($nomGenre);
        echo '<meta http-equiv="refresh" content="0;URL=index.php?admin=true">';
    }

    // Supprimer un groupe
    public function deleteGenre(String $nomGenre)
    {
        $content = $this->model->deleteGenre($nomGenre);
        echo '<meta http-equiv="refresh" content="0;URL=index.php?admin=true">';
    }

    // Sélection du genre
    public function getselectGenre(array $data)
    {
        $content = $this->model->findSelectGenre($data);
        if ($content) {
            echo '<meta http-equiv="refresh" content="0;URL=index.php?admin=true&modifGenre=true">';
        } else {
            echo '<meta http-equiv="refresh" content="0;URL=index.php?admin=true">';
        }
    }

    // Modification du genre
    public function updateGenre(array $dataSession, array $dataPOST)
    {
        $content = $this->model->updateGenre($dataSession, $dataPOST);
        echo '<meta http-equiv="refresh" content="0;URL=index.php?admin=true">';
    }

}
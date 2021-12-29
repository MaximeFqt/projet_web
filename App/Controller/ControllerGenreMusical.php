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

}
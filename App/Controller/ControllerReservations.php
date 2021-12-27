<?php

namespace App\Controller;

use App\Model\ModelReservations;
use App\Model\Model;

class ControllerReservations
{

    private Model $model;
    //private $view;

    public function __construct()
    {
        $this->model = new ModelReservations();
        //$this->view = new View();
    }

    // Retourne toutes les réservations d'un utilisateur
    public function getAllFromUser($idUser)
    {

        $content = $this->model->findAllFromUser($idUser);

        if (!empty($content)) {
            $_SESSION['panier'] = 'unfree';
        } else {
            $_SESSION['panier'] = 'empty';
        }

        include('App/View/getAllReservUser.php');

    }

    // Annule une réservation
    public function annulReserv($idRes)
    {
        $annul = $this->model->deleteRes($idRes);
        echo '<meta http-equiv="refresh" content="0;URL=index.php?panier=true">';
    }

    // Ajoute une réservation
    public function addReserv($nbPlace)
    {
        $reserv = $this->model->insertRes($nbPlace);
    }

}
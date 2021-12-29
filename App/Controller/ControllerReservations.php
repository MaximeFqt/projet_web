<?php

namespace App\Controller;

use App\Model\ModelReservations;
use App\Model\Model;

class ControllerReservations
{

    private Model  $model;
    private String $view;

    public function __construct()
    {
        $this->model = new ModelReservations();
        //$this->view = new View();
    }

    /**
     * @param String $view
     */
    public function setView(string $view): void
    {
        $this->view = $view;
    }

    public function getAll()
    {
        $content = $this->model->findAll();

        $this->getView();
        include($this->view);
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

        $this->getViewReservUser();
        include($this->view);
    }

    // Annule une réservation
    public function annulReserv($idRes)
    {
        $annul = $this->model->deleteRes($idRes);
        if (isset($_GET['admin']) && !empty($_GET['admin']) &&$_GET['admin'] == 'true'
                &&
            isset($_GET['deleteRes']) && !empty($_GET['deleteRes']) && $_GET['deleteRes'] == 'true')
        {
            echo '<meta http-equiv="refresh" content="0;URL=index.php?admin=true">';
        } else {
            echo '<meta http-equiv="refresh" content="0;URL=index.php?panier=true">';
        }
    }

    // Ajoute une réservation
    public function addReserv($nbPlace)
    {
        $reserv = $this->model->insertRes($nbPlace);
    }

    // Affiche la viewReservUser
    public function getViewReservUser()
    {
        $this->setView('App/View/getAllReservUser.php');
    }

    // Affiche la view
    public function getView()
    {
        $this->setView('App/View/getAllReserv.php');

    }

}
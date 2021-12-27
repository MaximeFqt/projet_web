<?php

namespace App\Model;

use App\Entity\Reservations;

class ModelReservations extends Model
{

    public function __construct()
    {
        parent::__construct("reservations");
    }

    public function findAll()
    {
        $reserv = $this->find();
        $reservs = array();

        foreach ($reserv as $uneReserv) {
            $uneReserv = new Reservations(
                array(
                    "idReserv"  => $uneReserv['id_res'],
                    "idUser"    => $uneReserv['idUser'],
                    "idConcert" => $uneReserv['idConcert'],
                    "nbPlace"   => $uneReserv['nbPlace'],
                    "prixTotal" => $uneReserv['prixTotal'],
                    "groupe"    => $uneReserv['groupe'],
                    "lieu"      => $uneReserv['lieu'],
                    "date"      => $uneReserv['date']
                )
            );
            array_push($reservs, $uneReserv);
        }

        return $reservs;
    }

}
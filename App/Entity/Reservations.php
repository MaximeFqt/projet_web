<?php

namespace App\Entity\Reservations;

use Cassandra\Date;

class Reservations
{

    private int    $idReserv;
    private int    $idUser;
    private int    $idConcert;
    private int    $nbPlace;
    private float  $prixTotal;
    private int    $groupe;
    private String $lieu;
    private Date   $date;

}
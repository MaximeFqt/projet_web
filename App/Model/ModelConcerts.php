<?php

namespace App\Model;

use App\Entity\Concerts;

class ModelConcerts extends Model
{

    public function __construct()
    {
        parent::__construct("concerts");
    }

    // Récupère tous les concerts
    public function findAll()
    {
        $sql = "select * from concerts C join groupes G on G.id_groupe = C.groupe order by rand() limit 3;";
        $concert = $this->getConnexion()->query($sql);
        $concerts = array();

        foreach ($concert as $unConcert) {
            array_push($concerts, $unConcert);
        }

        return $concerts;
    }

    // Trouve un concert par son idée
    public function findOne($id, $nomGroupe) : array {
        $sql = "select * from concerts C join groupes G on G.id_groupe = C.groupe where C.id_concert = '$id' and G.nom = '$nomGroupe';";
        $concert = $this->getConnexion()->query($sql);

        $concerts = array();

        foreach ($concert as $unConcert) {
            array_push($concerts, $unConcert);
        }

        return $concerts;
    }

    public function getOneCategorie($id)
    {
        if ($id == 'all') {
            $sql = "select * from concerts C join groupes Gr on Gr.id_groupe = C.groupe;";
        } else {
            // Récupère les concerts contenants le genre recherché
            $sql = "select * from concerts C join groupes G on G.id_groupe = C.groupe where G.genre = '$id';";
        }

        $concert = $this->getConnexion()->query($sql);
        $concerts = array();

        foreach ($concert as $unConcert) {
            array_push($concerts, $unConcert);
        }

        return $concerts;
    }

}
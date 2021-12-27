<?php

namespace App\Model;

use App\Entity\Groupes;

class ModelGroupes extends Model
{

    public function __construct()
    {
        parent::__construct("groupes");
    }

    public function findAll()
    {
        $groupe = $this->find();
        $groupes = array();

        foreach ($groupe as $unGroupe) {
            $unGroupe = new Groupes(
                array(
                    "idGroupe" => $unGroupe['id_groupe'],
                    "nom"      => $unGroupe['nom'],
                    "genre"    => $unGroupe['genre'],
                    "image"    => $unGroupe['image']
                )
            );
            array_push($groupes, $unGroupe);
        }

        return $groupes;
    }


}
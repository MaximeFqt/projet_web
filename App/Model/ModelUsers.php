<?php

namespace App\Model;

use App\Entity\Users;

class ModelUsers extends Model
{

    public function __construct()
    {
        parent::__construct("users");
    }

    public function findAll()
    {
        $user = $this->find();
        $users = array();

        foreach ($user as $unUser) {
            $unUser = new Users(
                array(
                    "idUser" => $unUser['id_user'],
                    "login"  => $unUser['login'],
                    "pass"   => $unUser['pass'],
                    "email"  => $unUser['email']
                )
            );
            array_push($users, $unUser);
        }

        return $users;
    }

}
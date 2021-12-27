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
                    "idUser" => $unUser['idUser'],
                    "login"  => $unUser['login'],
                    "pass"   => $unUser['pass'],
                    "email"  => $unUser['email']
                )
            );
            array_push($users, $unUser);
        }

        return $users;
    }

    // Trouve l'utilisateur par rapport à son login
    public function findByParam($login): array
    {
        $users = array();

        $sql = "select * from users where login = '$login';";
        $user = $this->getConnexion()->query($sql);

        if ($user->rowCount() === 1) {
            foreach ($user as $unUser) {
                array_push($users, $unUser);
            }
        }
        return $users;
    }


}
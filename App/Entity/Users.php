<?php

namespace App\Entity;

class Users
{

    private int    $idUser;
    private String $login;
    private String $pass;
    private String $email;

    /**
     * Constructeur
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->hydrate($data);
    }

    /**
     * @param array $donnees
     */
    public function hydrate(array $donnees) : void
    {
        foreach ($donnees as $key => $value)
        {
            $method = 'set'.ucfirst($key);

            if (method_exists($this, $method))
            {
                $this->$method($value);
            }
        }
    }

    // GETTERS

    /**
     * @return int
     */
    public function getIdUser(): int
    {
        return $this->idUser;
    }

    /**
     * @return String
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @return String
     */
    public function getPass(): string
    {
        return $this->pass;
    }

    /**
     * @return String
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    // GETTERS

    /**
     * @param int $idUser
     */
    public function setIdUser(int $idUser): void
    {
        $this->idUser = $idUser;
    }

    /**
     * @param String $login
     */
    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    /**
     * @param String $pass
     */
    public function setPass(string $pass): void
    {
        $this->pass = $pass;
    }

    /**
     * @param String $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }



}
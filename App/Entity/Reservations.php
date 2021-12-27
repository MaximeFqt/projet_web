<?php

namespace App\Entity;

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
    public function getIdReserv(): int
    {
        return $this->idReserv;
    }

    /**
     * @return int
     */
    public function getIdUser(): int
    {
        return $this->idUser;
    }

    /**
     * @return int
     */
    public function getIdConcert(): int
    {
        return $this->idConcert;
    }

    /**
     * @return int
     */
    public function getNbPlace(): int
    {
        return $this->nbPlace;
    }

    /**
     * @return float
     */
    public function getPrixTotal(): float
    {
        return $this->prixTotal;
    }

    /**
     * @return int
     */
    public function getGroupe(): int
    {
        return $this->groupe;
    }

    /**
     * @return String
     */
    public function getLieu(): string
    {
        return $this->lieu;
    }

    /**
     * @return Date
     */
    public function getDate(): Date
    {
        return $this->date;
    }

    // SETTERS

    /**
     * @param int $idReserv
     */
    public function setIdReserv(int $idReserv): void
    {
        $this->idReserv = $idReserv;
    }

    /**
     * @param int $idUser
     */
    public function setIdUser(int $idUser): void
    {
        $this->idUser = $idUser;
    }

    /**
     * @param int $idConcert
     */
    public function setIdConcert(int $idConcert): void
    {
        $this->idConcert = $idConcert;
    }

    /**
     * @param int $nbPlace
     */
    public function setNbPlace(int $nbPlace): void
    {
        $this->nbPlace = $nbPlace;
    }

    /**
     * @param float $prixTotal
     */
    public function setPrixTotal(float $prixTotal): void
    {
        $this->prixTotal = $prixTotal;
    }

    /**
     * @param int $groupe
     */
    public function setGroupe(int $groupe): void
    {
        $this->groupe = $groupe;
    }

    /**
     * @param String $lieu
     */
    public function setLieu(string $lieu): void
    {
        $this->lieu = $lieu;
    }

    /**
     * @param Date $date
     */
    public function setDate(Date $date): void
    {
        $this->date = $date;
    }



}
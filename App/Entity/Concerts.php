<?php

namespace App\Entity;

class Concerts
{

    private int    $idConcert;
    private int    $groupe;
    private String $lieu;
    private String $date;
    private float  $prixPlace;

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

    /** @return int */
    public function getIdConcert(): int { return $this->idConcert; }
    /** @return int */
    public function getGroupe(): int { return $this->groupe; }
    /** @return String */
    public function getLieu(): string { return $this->lieu; }
    /** @return String */
    public function getDate(): string { return $this->date; }
    /** @return float */
    public function getPrixPlace(): float { return $this->prixPlace; }

    // SETTERS
    /** @param int $idConcert */
    public function setIdConcert(int $idConcert): void { $this->idConcert = $idConcert; }
    /** @param int $groupe */
    public function setGroupe(int $groupe): void { $this->groupe = $groupe; }
    /** @param String $lieu */
    public function setLieu(string $lieu): void { $this->lieu = $lieu; }
    /** @param String $date */
    public function setDate(string $date): void { $this->date = $date; }
    /** @param float $prixPlace */
    public function setPrixPlace(float $prixPlace): void { $this->prixPlace = $prixPlace; }



}
<?php

namespace App\Entity;

class GenreMusical
{

    private int    $idGenre;
    private String $nomGenre;

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
    public function getIdGenre(): int
    {
        return $this->idGenre;
    }

    /**
     * @return String
     */
    public function getNomGenre(): string
    {
        return $this->nomGenre;
    }

    // SETTERS

    /**
     * @param int $idGenre
     */
    public function setIdGenre(int $idGenre): void
    {
        $this->idGenre = $idGenre;
    }

    /**
     * @param String $nomGenre
     */
    public function setNomGenre(string $nomGenre): void
    {
        $this->nomGenre = $nomGenre;
    }








}
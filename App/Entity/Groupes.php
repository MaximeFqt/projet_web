<?php

namespace App\Entity;

class Groupes
{

    private int    $idGroupe;
    private String $nom;
    private int    $genre;
    private String $image;

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
    public function getIdGroupe(): int
    {
        return $this->idGroupe;
    }

    /**
     * @return String
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * @return int
     */
    public function getGenre(): int
    {
        return $this->genre;
    }

    /**
     * @return String
     */
    public function getImage(): string
    {
        return $this->image;
    }

    // SETTERS

    /**
     * @param int $idGroupe
     */
    public function setIdGroupe(int $idGroupe): void
    {
        $this->idGroupe = $idGroupe;
    }

    /**
     * @param String $nom
     */
    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @param int $genre
     */
    public function setGenre(int $genre): void
    {
        $this->genre = $genre;
    }

    /**
     * @param String $image
     */
    public function setImage(string $image): void
    {
        $this->image = $image;
    }



}
<?php

namespace App\Model;

use App\Entity\GenreMusical;

class ModelGenreMusical extends Model
{

    public function __construct()
    {
        parent::__construct("genremusical");
    }

    // Trouve tous les genres
    public function findAll()
    {
        $genre = $this->find();
        $genres = array();

        foreach ($genre as $unGenre) {
            $unGenre = new GenreMusical(
                array(
                    "idGenre"  => $unGenre['id_genre'],
                    "nomGenre" => $unGenre['nomGenre']
                )
            );
            array_push($genres, $unGenre);
        }

        return $genres;
    }

    // Trouve les genres avec les groupes et les concerts liés
    public function findGenre($genre)
    {
        $sql = "select * from concerts C join groupes G on G.idGroupe = C.groupe join genremusical Gm on Gm.idGenre = G.genre
        where G.genre = '$genre' order by rand() limit 3;";

        $dataGenre = $this->getConnexion()->query($sql);
        $genres = array();

        foreach ($dataGenre as $unGenre) {
            array_push($genres, $unGenre);
        }

        return $genres;
    }

}
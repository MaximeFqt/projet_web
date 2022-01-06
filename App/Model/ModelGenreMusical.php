<?php

namespace App\Model;

use App\Entity\GenreMusical;

class ModelGenreMusical extends Model
{

    public function __construct()
    {
        $this->table = "genremusical";
        parent::__construct($this->table);
    }

    // Trouve tous les genres
    public function findAll(): array
    {
        $genre = $this->find();
        $genres = array();

        foreach ($genre as $unGenre) {
            $unGenre = new GenreMusical(
                array(
                    "idGenre"  => $unGenre['idGenre'],
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
        $sql = "select * from concerts C join groupes G on G.idGroupe = C.groupe join $this->table Gm on Gm.idGenre = G.genre
        where G.genre = '$genre' order by rand() limit 3;";

        $dataGenre = $this->getConnexion()->query($sql);
        $genres = array();

        foreach ($dataGenre as $unGenre) {
            array_push($genres, $unGenre);
        }

        return $genres;
    }

    // Ajout d'un genre
    public function insertGenre(String $nomGenre): void
    {
        $sql = "select * from $this->table where nomGenre = '$nomGenre';";

        $genres = $this->getConnexion()->query($sql);
        if ($genres->rowCount() === 0) {

            // Ajout du genre
            $sqlInsertGenre = "insert into $this->table (nomGenre) values ('$nomGenre')";
            $insertGenre = $this->getConnexion()->exec($sqlInsertGenre);

            $_SESSION['updateSite'] = 'AjtGenre';

        } else {
            // Affichage de l'alerte
            echo '<body onload = "alert(\'Ce concert existe déjà \')" >';
            echo '<meta http-equiv="refresh" content="0;URL=index.php?admin=true">';
        }

    }

    // Suppression d'un genre
    public function deleteGenre(String $nomGenre): void
    {
        $sql = "select * from $this->table where nomGenre = '$nomGenre';";
        $genres = $this->getConnexion()->query($sql); // Envoie


        if ($genres->rowCount() === 1) {

            $genre = $genres->fetchAll(\PDO::FETCH_ASSOC);

            $idGenre = $genre[0]['idGenre'];

            $this->delete($idGenre);

            $_SESSION['updateSite'] = 'SprGenre';

        } else {
            echo '<body onload = "alert(\'Ce groupe n`existe pas ! \')" >';
            echo '<meta http-equiv="refresh" content="0;URL=index.php?admin=true">';
        }

    }

    // Sélection du genre
    public function findSelectGenre(array $data): bool
    {
        $nomGenre = $data['nomGenre'];

        $sql = "select * from $this->table where nomGenre = '$nomGenre';";
        $genres = $this->getConnexion()->query($sql);

        if ($genres->rowCount() === 1) {

            // Traitement de la requête
            $genre = $genres->fetchAll(\PDO::FETCH_ASSOC);

            // Stockage valeur utile pour la modification
            $_SESSION['idGenre'] = $genre[0]['idGenre'];

            return true;

        } else {
            echo '<body onload = "alert(\'Ce genre n`existe pas\')" >';
            return false;
        }

    }

    // Modification du genre
    public function updateGenre(array $dataSession, array $dataPOST)
    {
        $idGenre = $dataSession['idGenre'];

        $nomGgenre = $dataPOST['nomGenre'];

        // Requête
        $sql = "select * from $this->table where idGenre = '$idGenre';";
        $recupGenre = $this->getConnexion()->query($sql);

        if ($recupGenre->rowCount() == 1) {

            // Modification du concert
            $updateGenre = "update $this->table set nomGenre = '$nomGgenre' where idGenre = '$idGenre';";

            $update = $this->getConnexion()->exec($updateGenre);

            $_SESSION['updateSite'] = "modifGenre";

            // Suppression des variables de session inutiles
            unset($_SESSION['idGenre']);

        } else {
            echo '<body onload = "alert(\'Concert Genre\')" >';
        }
    }

}
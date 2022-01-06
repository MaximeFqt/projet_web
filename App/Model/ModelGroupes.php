<?php

namespace App\Model;

use App\Entity\Groupes;

class ModelGroupes extends Model
{

    public function __construct()
    {
        $this->table = "groupes";
        parent::__construct($this->table);
    }

    public function findAll()
    {
        $groupe = $this->find();
        $groupes = array();

        foreach ($groupe as $unGroupe) {
            $unGroupe = new Groupes(
                array(
                    "idGroupe" => $unGroupe['idGroupe'],
                    "nom"      => $unGroupe['nom'],
                    "genre"    => $unGroupe['genre'],
                    "image"    => $unGroupe['image']
                )
            );
            array_push($groupes, $unGroupe);
        }

        return $groupes;
    }

    // Ajout d'un groupe
    public function insertGroupe(array $data): void
    {
         $nomGroupe = $data['nomGroupe'];
         $genre    = $data['genre'];

        $sql = "select * from $this->table Gr join genremusical Gm on Gm.idGenre = Gr.genre
                       where Gm.nomGenre = '$genre' and Gr.nom = '$nomGroupe';";

        $genres = $this->getConnexion()->query($sql); // Envoie

        if ($genres->rowCount() === 0) {

            $recupGenre = "select * from genremusical where nomGenre = '$genre';";
            $recupGenres = $this->getConnexion()->query($recupGenre);
            $recupGenre = $recupGenres->fetchAll(\PDO::FETCH_ASSOC);

            // Si le nom du groupe correspond à la récupération de la requête
            if ($genre == $recupGenre[0]['nomGenre']) {


                $idGenre = $recupGenre[0]['idGenre'];

                $image = $this->getImage();

                // Ajout du groupe
                $sqlInsertGroupe = "insert into $this->table (nom, genre, image) values ('$nomGroupe', '$idGenre', '$image')";
                $insertGroupe = $this->getConnexion()->exec($sqlInsertGroupe);

                $_SESSION['updateSite'] = 'AjtGroupe';

            } else {
                // Affichage de l'alerte
                echo '<body onload = "alert(\'Ce groupe n`existe pas \')" >';
            }
        } else {
            // Affichage de l'alerte
            echo '<body onload = "alert(\'Ce groupe existe déjà \')" >';
            echo '<meta http-equiv="refresh" content="0;URL=index.php?admin=true">';
        }
    }

    // Supprimer un groupe
    public function deleteGroupe(array $data)
    {
        $nomGroupe = $data['nomGroupe'];
        $genre    = $data['genre'];

        $sql = "select * from $this->table Gr join genremusical Gm on Gm.idGenre = Gr.genre
                       where Gm.nomGenre = '$genre' and Gr.nom = '$nomGroupe';";

        $groupes = $this->getConnexion()->query($sql); // Envoie


        if ($groupes->rowCount() === 1) {

            $groupe = $groupes->fetchAll(\PDO::FETCH_ASSOC);

            $idGroupe = $groupe[0]['idGroupe'];

            $this->delete($idGroupe);

            $_SESSION['updateSite'] = 'SprGroupe';

        } else {
            echo '<body onload = "alert(\'Ce groupe n`existe pas ! \')" >';
            echo '<meta http-equiv="refresh" content="0;URL=index.php?admin=true">';
        }
    }

    // Sélection du groupe
    public function findSelectGroupe(array $data): bool
    {
        $nomGroupe = $data['nomGroupe'];
        $genre     = $data['genre'];

        // Requête et envoie
        $sql = "select * from $this->table Gr join genremusical Gm on Gm.idGenre = Gr.genre 
                where Gr.nom = '$nomGroupe' and Gm.nomGenre = '$genre';";
        $recupGrp = $this->getConnexion()->query($sql);

        if ($recupGrp->rowCount() === 1) {

            $grp = $recupGrp->fetchAll(\PDO::FETCH_ASSOC);
            $idGrp = $grp[0]['idGroupe'];

            $groupes = $this->find();

            $groupe = array();

            foreach ($groupes as $unGroupe) {
                if ($idGrp == $unGroupe['idGroupe'] && $genre == $unGroupe['genre']) {
                    array_push($groupe, $unGroupe);
                    break;
                }
            }

            // Stockage valeur utile pour la modification
            $_SESSION['idGroupe'] = $idGrp;

            return true;

        } else {
            echo '<body onload = "alert(\'Ce groupe ou ce genre n`existe pas\')" >';
            return false;
        }
    }

    // Modification du groupe sélectionné
    public function updateGroupe(array $dataSession, array $dataPOST)
    {
        $idGroupe = $dataSession['idGroupe'];

        $nomGroupe = $dataPOST['nomGroupe'];
        $genre     = $dataPOST['genre'];

        $recupGenre = "select * from genremusical where nomGenre = '$genre';";
        $recupIdGroupe = $this->getConnexion()->query($recupGenre);

        if ($recupIdGroupe->rowCount() === 1) {
            $genres = $recupIdGroupe->fetchAll(\PDO::FETCH_ASSOC);

            $idGenre = $genres[0]['idGenre'];

            // Requête
            $sql = "select * from groupes where idGroupe = '$idGroupe';";
            $recupGroupe = $this->getConnexion()->query($sql);

            if ($recupGroupe->rowCount() == 1) {

                $grp = $recupGroupe->fetchAll(\PDO::FETCH_ASSOC);

                $image = $this->getImage();

                // Modification du concert
                $updateGroupe = "update $this->table set nom = '$nomGroupe', genre = '$idGenre', image = '$image' where idGroupe = '$idGroupe';";

                $update = $this->getConnexion()->exec($updateGroupe);

                $_SESSION['updateSite'] = "modifGroupe";

                // Suppression des variables de session inutiles
                unset($_SESSION['idGroupe']);

            } else {
                echo '<body onload = "alert(\'Groupe inexistant\')" >';
            }
        } else {
            echo '<body onload = "alert(\'Genre inexistant\')" >';
        }

    }


}
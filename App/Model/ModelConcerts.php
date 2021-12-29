<?php

namespace App\Model;

use App\Entity\Concerts;

class ModelConcerts extends Model
{

    public function __construct()
    {
        parent::__construct("concerts");
    }

    public function findAll(): array
    {
        $concert = $this->find();
        $concerts = array();

        foreach ($concert as $unConcert) {
            $unConcert = new Concerts(
                array(
                    "idConcert" => $unConcert['idConcert'],
                    "groupe"    => $unConcert['groupe'],
                    "lieu"      => $unConcert['lieu'],
                    "date"      => $unConcert['date'],
                    "prixPlace" => $unConcert['prixPlace']
                )
            );
            array_push($concerts, $unConcert);
        }

        return $concerts;
    }

    // Récupère trois concerts
    public function findThree()
    {
        $sql = "select * from concerts C join groupes G on G.idGroupe = C.groupe order by rand() limit 3;";
        $concert = $this->getConnexion()->query($sql);
        $concerts = array();

        foreach ($concert as $unConcert) {
            array_push($concerts, $unConcert);
        }

        return $concerts;
    }

    // Trouve un concert par son idée
    public function findOne($id, $nomGroupe) : array
    {
        $sql = "select * from concerts C join groupes G on G.idGroupe = C.groupe where C.idConcert = '$id' and G.nom = '$nomGroupe';";
        $concert = $this->getConnexion()->query($sql);

        $concerts = array();

        foreach ($concert as $unConcert) {
            array_push($concerts, $unConcert);
        }

        return $concerts;
    }

    public function findOneCategorie($id): array
    {
        if ($id == 'all') {
            $sql = "select * from concerts C join groupes Gr on Gr.idGroupe = C.groupe;";
        } else {
            // Récupère les concerts contenants le genre recherché
            $sql = "select * from concerts C join groupes G on G.idGroupe = C.groupe where G.genre = '$id';";
        }

        $concert = $this->getConnexion()->query($sql);
        $concerts = array();

        foreach ($concert as $unConcert) {
            array_push($concerts, $unConcert);
        }

        return $concerts;
    }

    // Ajoute un concert
    public function insertConcert(array $data): void
    {
        $nomGroupe = $data['groupe'];
        $date      = $data['date'];
        $lieu      = $data['lieu'];
        $prix      = $data['prix'];

        $sql = "select * from concerts C join groupes Gr on Gr.idGroupe = C.groupe 
                where Gr.nom = '$nomGroupe' and C.date = '$date' and C.lieu = '$lieu' and C.prixPlace = '$prix';";

        $concerts = $this->getConnexion()->query($sql);

        if ($concerts->rowCount() === 0) {

            $recupGroupe = "select * from groupes where nom = '$nomGroupe';";
            $idGrps = $this->getConnexion()->query($recupGroupe);
            $idGrp = $idGrps->fetchAll(\PDO::FETCH_ASSOC);

            // Si le nom du groupe correspond à la récupération de la requête
            if ($nomGroupe == $idGrp[0]['nom']) {


                $id = $idGrp[0]['idGroupe'];

                // Ajout du concert
                $sqlInsertConcert = "insert into concerts (groupe, lieu, date, prixPlace) values ('$id', '$lieu', '$date', '$prix')";
                $insertConcert = $this->getConnexion()->exec($sqlInsertConcert);

                $_SESSION['updateSite'] = 'AjtConcert';

            } else {
                // Affichage de l'alerte
                echo '<body onload = "alert(\'Ce groupe n`existe pas \')" >';
            }
        } else {
            // Affichage de l'alerte
            echo '<body onload = "alert(\'Ce concert existe déjà \')" >';
            echo '<meta http-equiv="refresh" content="0;URL=index.php?admin=true">';
        }
    }

    // Supprime un concert
    public function deleteConcert(array $data): void
    {
        $nomGroupe = $data['groupe'];
        $date      = $data['date'];
        $lieu      = $data['lieu'];

        $sql = "select * from concerts C join groupes Gr on Gr.idGroupe = C.groupe 
                where Gr.nom = '$nomGroupe' and C.date = '$date' and C.lieu = '$lieu';";

        $concerts = $this->getConnexion()->query($sql);


        if ($concerts->rowCount() > 0) {

            $concert = $concerts->fetchAll(\PDO::FETCH_ASSOC);

            $idConcert = $concert[0]['idConcert'];

            $this->delete($idConcert);

            header('location: index.php?admin=true');

        } else {
            echo '<body onload = "alert(\'Ce concert n`existe pas ! \')" >';
            echo '<meta http-equiv="refresh" content="0;URL=index.php?admin=true">';
        }
    }

}

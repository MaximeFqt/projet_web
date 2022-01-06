<?php

namespace App\Model;

use App\Entity\Concerts;

class ModelConcerts extends Model
{

    public function __construct()
    {
        $this->table = "concerts";
        parent::__construct($this->table);
    }

    public function findAll(): array
    {
        $concert = $this->find();
        $concerts = array();

        foreach ($concert as $unConcert) {
            $unConcert = new Concerts(
                array(
                    "idConcert" => $unConcert['idConcert'],
                    "groupe" => $unConcert['groupe'],
                    "lieu" => $unConcert['lieu'],
                    "date" => $unConcert['date'],
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
        $sql = "select * from $this->table C join groupes G on G.idGroupe = C.groupe order by rand() limit 3;";
        $concert = $this->getConnexion()->query($sql);
        $concerts = array();

        foreach ($concert as $unConcert) {
            array_push($concerts, $unConcert);
        }

        return $concerts;
    }

    // Trouve un concert par son idée
    public function findOne($id, $nomGroupe): array
    {
        $sql = "select * from $this->table C join groupes G on G.idGroupe = C.groupe where C.idConcert = '$id' and G.nom = '$nomGroupe';";
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
            $sql = "select * from $this->table C join groupes Gr on Gr.idGroupe = C.groupe;";
        } else {
            // Récupère les concerts contenants le genre recherché
            $sql = "select * from $this->table C join groupes G on G.idGroupe = C.groupe where G.genre = '$id';";
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
        $date = $data['date'];
        $lieu = $data['lieu'];
        $prix = $data['prix'];

        $sql = "select * from $this->table C join groupes Gr on Gr.idGroupe = C.groupe 
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
                $sqlInsertConcert = "insert into $this->table (groupe, lieu, date, prixPlace) values ('$id', '$lieu', '$date', '$prix')";
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
        $date = $data['date'];
        $lieu = $data['lieu'];

        $sql = "select * from $this->table C join groupes Gr on Gr.idGroupe = C.groupe 
                where Gr.nom = '$nomGroupe' and C.date = '$date' and C.lieu = '$lieu';";

        $concerts = $this->getConnexion()->query($sql);


        if ($concerts->rowCount() === 1) {

            $concert = $concerts->fetchAll(\PDO::FETCH_ASSOC);

            $idConcert = $concert[0]['idConcert'];

            $this->delete($idConcert);

            $_SESSION['updateSite'] = 'SprConcert';

        } else {
            echo '<body onload = "alert(\'Ce concert n`existe pas ! \')" >';
            echo '<meta http-equiv="refresh" content="0;URL=index.php?admin=true">';
        }
    }

    // Récupère le concert sélectionné
    public function findSelectConcert(array $data): bool
    {
        $nomGroupe = $data['nomGroupe'];
        $lieu = $data['lieu'];
        $date = $data['date'];

        $sql = "select * from groupes Gr join $this->table C on C.groupe = Gr.idGroupe
                where Gr.nom = '$nomGroupe' and C.lieu = '$lieu' and C.date = '$date';";
        $grps = $this->getConnexion()->query($sql);

        if ($grps->rowCount() === 1) {

            $grp = $grps->fetchAll(\PDO::FETCH_ASSOC);
            $idGrp = $grp[0]['idGroupe'];

            $concerts = $this->find();
            $concert = array();

            foreach ($concerts as $unConcert) {
                if ($idGrp == $unConcert['groupe'] && $lieu == $unConcert['lieu'] && $date == $unConcert['date']) {
                    array_push($concert, $unConcert);
                    break;
                }
            }

            // Stockage des variables utiles pour la modification
            $_SESSION['idConcert'] = $concert[0]['idConcert'];
            $_SESSION['idGroupe'] = $concert[0]['groupe'];

            return true;

        } else {
            echo '<body onload = "alert(\'Concert inexistant\')" >';
            return false;
        }
    }

    // Modifie le concert sélectionné
    public function updateConcert(array $dataSession, array $dataPOST)
    {
        $idConcert = $dataSession['idConcert'];
        $idGroupe = $dataSession['idGroupe'];

        $nomGroupe = $dataPOST['nomGroupe'];
        $lieu = $dataPOST['lieu'];
        $date = $dataPOST['date'];
        $prix = $dataPOST['prix'];

        // Requête
        $sql = "select * from $this->table where idConcert = '$idConcert';";
        $recupConcert = $this->getConnexion()->query($sql);

        if ($recupConcert->rowCount() == 1) {

            // Modification du concert
            $updateConcert = "update $this->table set groupe = '$idGroupe', lieu = '$lieu', date = '$date', 
                                    prixPlace = '$prix' where idConcert = '$idConcert';";

            $update = $this->getConnexion()->exec($updateConcert);

            $_SESSION['updateSite'] = "modifConcert";

            // Suppression des variables de session inutiles
            unset($_SESSION['idConcert']);
            unset($_SESSION['idGroupe']);

        } else {
            echo '<body onload = "alert(\'Concert inexistant\')" >';
        }
    }

}

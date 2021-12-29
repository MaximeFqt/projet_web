<?php

namespace App\Model;

use App\Entity\Reservations;

class ModelReservations extends Model
{

    public function __construct()
    {
        parent::__construct("reservations");
    }

    // Trouve toutes les réservations
    public function findAll(): array
    {
        $reserv = $this->find();
        $reservs = array();

        foreach ($reserv as $uneReserv) {
            $uneReserv = new Reservations(
                array(
                    "idReserv"  => $uneReserv['idRes'],
                    "idUser"    => $uneReserv['user'],
                    "idConcert" => $uneReserv['concert'],
                    "nbPlace"   => $uneReserv['nbPlace'],
                    "prixTotal" => $uneReserv['prixTotal'],
                    "groupe"    => $uneReserv['groupe'],
                    "lieu"      => $uneReserv['lieu'],
                    "date"      => $uneReserv['date']
                )
            );
            array_push($reservs, $uneReserv);
        }

        return $reservs;
    }


    // Trouve toues les réservations selon l'utilisateur
    public function findAllFromUser($idUser): array
    {
        $reservs = array();

        $sql = "select * from reservations R join groupes Gr on Gr.idGroupe = R.groupe where R.user = '$idUser';";
        $reserv = $this->getConnexion()->query($sql);

        if ($reserv->rowCount() === 0) {
            $_SESSION['panier'] = 'empty';
        } else {
            $_SESSION['panier'] = 'unfree';

            foreach ($reserv as $uneReserv) {
                array_push($reservs, $uneReserv);
            }
        }

        return $reservs;
    }

    // Annule une réservation
    public function deleteRes($idRes): void
    {
        $sql = "select * from reservations R join groupes Gr on Gr.idGroupe = R.groupe where R.idRes = '$idRes';";
        $reserv = $this->getConnexion()->query($sql);

        if ($reserv->rowCount() === 1) {
            $this->delete($idRes);
        } else {
            // Redirection
            echo '<meta http-equiv="refresh" content="0;URL=index.php?panier=true">';
            // Message d'erreur
            echo '<body onload = "alert(\'Une erreur est survenue !\')" >';
        }
    }

    // Ajoute une réservationà la base de donnée
    public function insertRes($nbPlace): void
    {
        $nomRecup = htmlspecialchars($_GET['nom']);
        $idConcert = htmlspecialchars($_GET['id']);

        $sql = "select * from concerts Cr join groupes Gr on Gr.idGroupe = Cr.groupe 
                where Gr.nom = '$nomRecup' and Cr.idConcert = '$idConcert';";

        $concerts = $this->getConnexion()->query($sql);

        if ($concerts->rowCount() === 1) {

            $concert = $concerts->fetchAll(\PDO::FETCH_ASSOC);

            // Traitement de la réservation
            if (isset($_SESSION['idUser']) && !empty($_SESSION['idUser'])) {

                // Stockage des valeurs
                $nbPlace = htmlspecialchars($_POST['nbPlace']);
                $idUser = htmlspecialchars($_SESSION['idUser']);
                $idConcert = htmlspecialchars($concert[0]['idConcert']);
                $prix = htmlspecialchars($concert[0]['prixPlace']);
                $groupe = htmlspecialchars($concert[0]['idGroupe']);
                $lieu = htmlspecialchars($concert[0]['lieu']);
                $date = htmlspecialchars($concert[0]['date']);

                $prixTotal = $nbPlace * $prix;

                $sql = "insert into reservations (user, concert, nbPlace, prixTotal, groupe, lieu, date) 
                            values ('$idUser', '$idConcert', '$nbPlace', '$prixTotal', '$groupe', '$lieu', '$date');";

                $insertReservation = $this->getConnexion()->exec($sql);

            } else {
                echo '<body onload = "alert(\'Veuillez vous connecter !\')" >';
                echo '<meta http-equiv="refresh">';
            }
        } else {
            echo '<body onload = "alert(\'Concert inconnu\')" >';
            echo '<meta http-equiv="refresh" content="0;URL=index.php">';
        }

    }

}
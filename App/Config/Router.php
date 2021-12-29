<?php

namespace App\Config;

// Utilisation du fichier
use App\Config\Database;

use App\Controller\ControllerConcerts;
use App\Controller\ControllerGenreMusical;
use App\Controller\ControllerUsers;
use App\Controller\ControllerReservations;
use App\Controller\ControllerGroupes;

class Router
{

    // Instanciation d'une bdd
    private Database $db;
    private ControllerUsers $controllerUsers;
    private ControllerGenreMusical $controllerGenre;
    private ControllerConcerts $controllerConcerts;
    private ControllerReservations $controllerReserv;
    private ControllerGroupes $controllerGroupe;

    /**
     * @param $data
     */
    public function __construct()
    {
        $this->db = new Database();
        $this->db->getConnection();

        $this->controllerReserv = new ControllerReservations();
        $this->controllerUsers = new ControllerUsers();
        $this->controllerConcerts = new ControllerConcerts();
        $this->controllerGroupe = new ControllerGroupes();
        $this->controllerGenre = new ControllerGenreMusical();

    }

    public function start(): void
    {
        session_start();
        include('utils/header.php');

        ?>

            <!-- ===============================
                 INFORMATIONS DE CONNEXION
             =============================== -->


        <?php if (isset($_SESSION['role'])) : ?>
            <?php if ($_SESSION['role'] == 'admin') : ?>
                <p id="info_connection"> Vous êtes connecté en tant qu'administrateur </p>
            <?php else : ?>
                <p id="info_connection"> Vous êtes connecté en tant que : <?= $_SESSION['login']; ?> </p>
            <?php endif; ?>
        <?php else : ?>
            <p id="info_connection"> Vous n'êtes pas connecté </p>
        <?php endif; ?>

        <!-- ===============================
                 FORMULAIRE DE CONNEXION
             =============================== -->

        <form id="formulaire" method="post" action="../../index.php">
            <fieldset id="form-login">
                <legend>Identification administrateur</legend>
                <p>
                    <label for="identifiant">Identifiant: </label>
                    <input type="text" placeholder="identifiant" name="login" autocomplete="off" id="identifiant" required/>
                </p>
                <p>
                    <label for="motDePasse">Mot de passe:</label>
                    <input type="password" placeholder="Mot de passe" name="pass" id="motDePasse" required/>
                </p>
                <p>
                    <a href="../../index.php?ajoutUser=true" class="inscription"> Je m'inscrit </a>
                </p>
            </fieldset>
            <p class="submit">
                <input type="submit" id="btnSubmitLogin" value="Continuer" name="send"/>
                <input type="reset" id="btnResetLogin" value="Annuler" />
            </p>
        </form>

        <?php

        if (isset($_GET['admin']) && !empty($_GET['admin']) && $_GET['admin'] == 'true') {

            // Affichage global
            $this->controllerUsers->getViewAdmin();

            ?>

            <div id="table_status">
                <?php
                // Affichage des tables
                $this->controllerGroupe->getAll();
                $this->controllerConcerts->getAll();
                $this->controllerGenre->getAll();
                $this->controllerUsers->getAll();
                $this->controllerReserv->getAll();
                ?>
            </div>

            <?php

            // SUPPRIMER UNE RESERVATION
            if (isset($_GET['deleteRes']) && !empty($_GET['deleteRes']) && $_GET['deleteRes'] == 'true') {
                if (isset($_POST['annulReserv']) && isset($_POST['idRes']) && !empty('idRes')) {
                    $this->controllerReserv->annulReserv($_POST['idRes']);
                }

            }
            // AJOUT CONCERT
            else if (isset($_POST['sendAjtConcert'])) {
                if (!empty($_POST['nomGroupe']) && !empty($_POST['date']) && !empty($_POST['lieu']) && !empty($_POST['prix'])) {
                    // Stockage des valeurs
                    $nomGroupe = htmlspecialchars($_POST['nomGroupe']);
                    $date = htmlspecialchars($_POST['date']);
                    $lieu = htmlspecialchars($_POST['lieu']);
                    $prix = htmlspecialchars($_POST['prix']);

                    $data = array (
                        "groupe" => $nomGroupe,
                        "date"   => $date,
                        "lieu"   => $lieu,
                        "prix"   => $prix
                    );
                    $this->controllerConcerts->addConcert($data);

                } else {
                    echo '<body onload = "alert(\'Les données du formulaire ne sont pas valables\')" >';
                }
            }
            // SUPPRESSION D'UN CONCERT
            else if (isset($_POST['sendSprConcert'])) {
                if (!empty($_POST['nomGroupe']) && !empty($_POST['date']) && !empty($_POST['lieu'])) {
                    // Stockage des valeurs
                    $nomGroupe = htmlspecialchars($_POST['nomGroupe']);
                    $date = htmlspecialchars($_POST['date']);
                    $lieu = htmlspecialchars($_POST['lieu']);

                    $data = array (
                        "groupe" => $nomGroupe,
                        "date"   => $date,
                        "lieu"   => $lieu
                    );
                    $this->controllerConcerts->deleteConcert($data);
                } else {
                    echo '<body onload = "alert(\'Les données du formulaire ne sont pas valables\')" >';
                }

            }
            // AJOUT D'UN GROUPE
            else if (isset($_POST['sendAjtGrp'])) {
                if (!empty($_POST['nomGroupe']) && !empty($_POST['genre'])) {
                    $nomGroupe = htmlspecialchars($_POST['nomGroupe']);
                    $genre = htmlspecialchars($_POST['genre']);

                    $data = array (
                        "nomGroupe" => $nomGroupe,
                        "genre"     => $genre
                    );
                    $this->controllerGroupe->addGroupe($data);
                } else {
                    echo '<body onload = "alert(\'Les données du formulaire ne sont pas valables\')" >';
                }
            }
            // SUPPRESSION D'UN GROUPE
            else if (isset($_POST['sendSprGrp'])) {
                if (!empty($_POST['nomGroupe']) && !empty($_POST['genre'])) {
                    $nomGroupe = htmlspecialchars($_POST['nomGroupe']);
                    $genre = htmlspecialchars($_POST['genre']);

                    $data = array (
                        "nomGroupe" => $nomGroupe,
                        "genre"     => $genre
                    );
                    $this->controllerGroupe->deleteGroupe($data);
                } else {
                    echo '<body onload = "alert(\'Les données du formulaire ne sont pas valables\')" >';
                }
            }
            // AJOUT D'UN GENRE
            else if (isset($_POST['sendAjtGenre'])) {
                if (!empty($_POST['genre'])) {
                    $genre = htmlspecialchars($_POST['genre']);

                    $this->controllerGenre->addGenre($genre);
                } else {
                    echo '<body onload = "alert(\'Les données du formulaire ne sont pas valables\')" >';
                }
            }
            // SUPPRESSION D'UN GENRE
            else if (isset($_POST['sendSprGenre'])) {
                if (!empty($_POST['genre'])) {
                    $genre = htmlspecialchars($_POST['genre']);

                    $this->controllerGenre->deleteGenre($genre);
                } else {
                    echo '<body onload = "alert(\'Les données du formulaire ne sont pas valables\')" >';
                }
            }
            // SELECTION D'UN CONCERT
            else if (isset($_POST['sendMdfConcert'])) {
                if (!empty($_POST['nomGroupe']) && !empty($_POST['lieu']) && !empty($_POST['date'])) {
                    $nomGroupe = htmlspecialchars($_POST['nomGroupe']);
                    $lieu      = htmlspecialchars($_POST['lieu']);
                    $date      = htmlspecialchars($_POST['date']);

                    $data = array (
                        'nomGroupe' => $nomGroupe,
                        'lieu'      => $lieu,
                        'date'      => $date
                    );

                    $this->controllerConcerts->getSelectConcert($data);

                } else {
                    echo '<body onload = "alert(\'Les données du formulaire ne sont pas valables\')" >';
                }
            }
            // MODIFICATION DU CONCERT
            else if (isset($_GET['modifConcert']) && $_GET['modifConcert'] == 'true') {
                if (isset($_SESSION['idConcert']) && isset($_SESSION['idGroupe'])) {

                    // Stockage des valeurs
                    $idConcert = $_SESSION['idConcert'];
                    $idGroupe  = $_SESSION['idGroupe'];

                    if (isset($_POST['modificationConcert'])) {

                        // Stockage des valeurs
                        $nomGroupe = htmlspecialchars($_POST['nomGroupe']);
                        $lieu = htmlspecialchars($_POST['lieu']);
                        $date = htmlspecialchars($_POST['date']);
                        $prix = htmlspecialchars($_POST['prix']);

                        $dataSession = array(
                            'idConcert' => $idConcert,
                            'idGroupe' => $idGroupe
                        );
                        $dataPOST = array(
                            'nomGroupe' => $nomGroupe,
                            'lieu' => $lieu,
                            'date' => $date,
                            'prix' => $prix
                        );
                        $this->controllerConcerts->updateConcert($dataSession, $dataPOST);
                    }
                } else {
                    echo '<body onload = "alert(\'Aucun concert séléctionné !\')" >';
                    echo '<meta http-equiv="refresh" content="0;URL=index.php?admin=true">';
                }
            }
            // SELECTION DU GROUPE
            else if (isset($_POST['sendMdfGrp'])) {
                if (!empty($_POST['nomGroupe']) && !empty($_POST['genre'])) {
                    $nomGroupe = htmlspecialchars($_POST['nomGroupe']);
                    $genre     = htmlspecialchars($_POST['genre']);

                    $data = array (
                        'nomGroupe' => $nomGroupe,
                        'genre'      => $genre
                    );

                    $this->controllerGroupe->getSelectGroupe($data);

                } else {
                    echo '<body onload = "alert(\'Les données du formulaire ne sont pas valables\')" >';
                }
            }
            // MODIFICATION DU CONCERT
            else if (isset($_GET['modifGroupe']) && $_GET['modifGroupe'] == 'true') {
                if (isset($_SESSION['idGroupe'])) {

                    // Stockage des valeurs
                    $idGroupe  = $_SESSION['idGroupe'];

                    if (isset($_POST['modificationGrp']) && !empty($_POST['nomGroupe']) && !empty($_POST['genre'])) {

                        // Stockage des valeurs
                        $nomGroupe = htmlspecialchars($_POST['nomGroupe']);
                        $genre     = htmlspecialchars($_POST['genre']);

                        $dataSession = array(
                            'idGroupe' => $idGroupe
                        );
                        $dataPOST = array(
                            'nomGroupe' => $nomGroupe,
                            'genre' => $genre
                        );
                        $this->controllerGroupe->updateGroupe($dataSession, $dataPOST);
                    }
                } else {
                    echo '<body onload = "alert(\'Aucun groupe séléctionné !\')" >';
                    echo '<meta http-equiv="refresh" content="0;URL=index.php?admin=true">';
                }
            }
            // SELECTION DU GENRE
            else if (isset($_POST['sendMdfGenre'])) {
                if (isset($_POST['genre']) && !empty($_POST['genre'])) {
                    $nomGenre = htmlspecialchars($_POST['genre']);

                    $data = array (
                        'nomGenre' => $nomGenre,
                    );

                    $this->controllerGenre->getSelectGenre($data);

                } else {
                    echo '<body onload = "alert(\'Les données du formulaire ne sont pas valables\')" >';
                }
            }
            // MODIFICATION DU GENRE
            else if (isset($_GET['modifGenre']) && $_GET['modifGenre'] == 'true') {
                if (isset($_SESSION['idGenre']) && !empty($_SESSION['idGenre'])) {

                    // Stockage des valeurs
                    $idGenre = $_SESSION['idGenre'];

                    if (isset($_POST['modificationGenre']) && !empty($_POST['genre'])) {

                        // Stockage des valeurs
                        $nomGenre = htmlspecialchars($_POST['genre']);

                        $dataSession = array(
                            'idGenre' => $idGenre
                        );
                        $dataPOST = array(
                            'nomGenre' => $nomGenre
                        );
                        $this->controllerGenre->updateGenre($dataSession, $dataPOST);
                    }
                } else {
                    echo '<body onload = "alert(\'Aucun genre séléctionné !\')" >';
                    echo '<meta http-equiv="refresh" content="0;URL=index.php?admin=true">';
                }
            }

        }  else if (isset($_GET['logout']) && !empty($_GET['logout']) && $_GET['logout'] == 'true') {

            // Déconnexion
            $this->controllerUsers->logout();

        } else if (isset($_POST['send'])) {

            // Connexion
            $this->controllerUsers->login();

        } else if (isset($_POST) && !empty($_POST['sendAjoutUser'])) {

            // Inscription
            $this->controllerUsers->addUser();

        } else if (isset($_GET['nom']) && isset($_GET['id'])) {

            // Affichage des détails d'un concert
            $nomGroupe = htmlspecialchars($_GET['nom']);
            $idConcert = htmlspecialchars($_GET['id']);

            $this->controllerConcerts->getOne();

            if (isset($_POST['sendBuy']) && isset($_POST['nbPlace']) && !empty('nbPlace')) {
                // Réservation
                $this->controllerReserv->addReserv($_POST['nbPlace']);
            }

        } else if (isset($_GET['panier']) && $_GET['panier'] == "true") {

            if (isset($_SESSION['idUser']) && !empty($_SESSION['idUser'])) {
                // Affichage des réservations de l'utilisateur
                $this->controllerReserv->getAllFromUser($_SESSION['idUser']);

                if (isset($_POST['annulReserv']) && isset($_POST['idRes']) && $_POST['idRes']) {
                    // Annulation d'une réservation
                    $this->controllerReserv->annulReserv( $_POST['idRes'] );
                }
            } else {
                // Affichage de base du panier
                $this->controllerReserv->getViewReservUser();
            }

        } else if (isset($_GET['ajoutUser']) && $_GET['ajoutUser'] == "true") {

            // Affichage
            $this->controllerUsers->getView();

        } else if (isset($_GET['cat']) && !empty($_GET['cat'])
                    ||
                   isset($_POST['selectGenre']) && !empty($_POST['selectGenre'])) {

            // Affichage de tous les concerts en fonction du genre choisi
            $this->controllerConcerts->getCategorie( $_GET['cat'] );

        } else if (isset($_COOKIE['genre']) && $_COOKIE['genre'] != 'all') {

            // Affichage de trois concerts en fonction du cookie
            $this->controllerGenre->getGenre( $_COOKIE['genre'] );

        } else {

            // AFFICHAGE DE BASE DU SITE
            $this->controllerConcerts->getThree();

        }

        include('utils/footer.php');
    }

}
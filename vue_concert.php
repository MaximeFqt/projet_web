<?php

session_start();

// Utilisation du fichier
use App\Config\Database;

/* AUTOLOAD */
//autoload
function chargerClasse($classe)
{
    $classe=str_replace('\\','/',$classe);
    require $classe . '.php';
}
spl_autoload_register('chargerClasse'); //fin Autoload

if (isset($_SESSION['login']) && isset($_SESSION['pass']) && isset($_SESSION['id'])) {
    $login = $_SESSION['login'];
    $pass = $_SESSION['pass'];
    $id = $_SESSION['id'];
}

// Instanciation d'une bdd
$db = new Database();
$connexion = $db->getConnection();

if(isset($_GET['nom']) && isset($_GET['id'])) {
    if (!empty($_GET['nom']) && !empty($_GET['id'])) {
        $nomRecup = htmlspecialchars($_GET['nom']);
        $idConcert = htmlspecialchars($_GET['id']);

        $sql = "select * from concerts Cr join groupes Gr on Gr.id_groupe = Cr.groupe where Gr.nom = '$nomRecup' and Cr.id_concert = '$idConcert';";
        $concerts = $connexion->query($sql);

        if ($concerts->rowCount() === 1 ) {

            $concert = $concerts->fetchAll(PDO::FETCH_OBJ);

            // Traitement de la réservation
            if (isset($_POST['sendBuy']) && !empty($_POST['sendBuy'])) {
                if (!empty($_POST['nbPlace'])) {
                    if (isset($id) && !empty($id)) {

                        // Stockage des valeurs
                        $nbPlace   = htmlspecialchars($_POST['nbPlace']);
                        $idUser    = htmlspecialchars($_SESSION['id']);
                        $idConcert = htmlspecialchars($concert[0]->id_concert);
                        $prix      = htmlspecialchars($concert[0]->prix_place);
                        $groupe    = htmlspecialchars($concert[0]->id_groupe);
                        $lieu      = htmlspecialchars($concert[0]->lieu);
                        $date      = htmlspecialchars($concert[0]->date);

                        $prixTotal = $nbPlace * $prix;

                        $sql = "insert into reservations (idUser, idConcert, nbplace, prixTotal, groupe, lieu, date) 
                            values ('$idUser', '$idConcert', '$nbPlace', '$prixTotal', '$groupe', '$lieu', '$date');";

                        $insertReservation = $connexion->exec($sql);

                    } else {
                        echo '<body onload = "alert(\'Veuillez vous connecter !\')" >';
                        echo '<meta http-equiv="refresh">';
                    }
                } else {
                    echo '<body onload = "alert(\'Un problème est survenu !\')" >';
                    echo '<meta http-equiv="refresh">';
                }
            }
        } else {
            echo '<body onload = "alert(\'Concert inconnu\')" >';
            echo '<meta http-equiv="refresh" content="0;URL=index.php">';
        }
    } else {
        echo '<body onload = "alert(\'Concert inconnu\')" >';
        echo '<meta http-equiv="refresh" content="0;URL=index.php">';
    }
} else {
    echo '<body onload = "alert(\'Concert inconnu\')" >';
    echo '<meta http-equiv="refresh" content="0;URL=index.php">';
}

// Requete recuperation infos sur les groupes
$recupImage = "select * from concerts C join groupes G on G.id_groupe = C.groupe;";

$groupes = $connexion->query($recupImage);            // Envoie de la requête
$groupe = $groupes->fetchAll(PDO::FETCH_OBJ);   // Traitement

?>


<!doctype html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
            content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="css/reset.css" rel="stylesheet" type="text/css">
        <link href="css/layout.css" rel="stylesheet" type="text/css">
        <link href="css/color.css" rel="stylesheet" type="text/css">
        <script src="js/comportement.js"></script>
        <title> Concertôt </title>
    </head>
    <body>
        <?php require('header.php');?>

        <?php if (isset($role)) : ?>
            <?php if ($role == 'admin') : ?>
                <p id="info_connection"> Vous êtes connecté en tant qu'administrateur </p>
            <?php else : ?>
                <p id="info_connection"> Vous êtes connecté en tant que : <?= $login; ?> </p>
            <?php endif; ?>
        <?php else : ?>
            <p id="info_connection"> Vous n'êtes pas connecté </p>
        <?php endif; ?>

        <!-- ===============================
             FORMULAIRE DE CONNEXION
             =============================== -->

        <form id="formulaire" method="post" action="login.php">
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
                    <a href="ajoutUser.php" class="inscription"> Je m'inscrit </a>
                </p>
            </fieldset>
            <p class="submit">
                <input type="submit" id="btnSubmitLogin" value="Continuer" name="send"/>
                <input type="reset" id="btnResetLogin" value="Annuler" />
            </p>
        </form>

        <!-- ===============================
             AFFICHAGE DU CONCERT
             =============================== -->

        <p class="presentation"> <?=$nomRecup;?> </p>

        <div id="detail">
            <ul>
                <?php foreach ($groupe as $unGroupe) : ?>
                    <?php if ($nomRecup == $unGroupe->nom) : ?>
                        <li>
                            <?php $img_groupe = $unGroupe->image; ?>
                            <img src="<?=$img_groupe;?>" alt="<?=$_GET['nom'];?>">
                            <p>
                                Le concert du groupe <?=$unGroupe->nom;?> va avoir lieu à <?=$unGroupe->lieu;?>.
                            </p>
                            <p>
                                Il est prévu pour le <?= $unGroupe->date;?>.
                            </p>
                            <p>
                                Le prix de la place est de <?= $unGroupe->prix_place;?>€ par personne.
                            </p>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
                <li>
                    <form action="#" id="buy" method="post">
                        <p>
                            <label for="buy"> Réserver : </label>
                            <input type="number" id="buy" min="1" name="nbPlace" placeholder="Nombre de place" required/>
                        </p>
                        <p>
                            <input type="submit" id="btnOkReserv" value="Ok" name="sendBuy">
                        </p>
                    </form>
                </li>
            </ul>
        </div>

        <p class="retourIndex">
            <a href="index.php"> Retour </a>
        </p>

        <?php require('footer.php');?>
    </body>
</html>

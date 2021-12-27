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

// Instanciation d'une bdd
$db = new Database();
$connexion = $db->getConnection();

// Si l'utilisteur n'est pas administrateur
if (!(isset($_SESSION['role']))) {
    header('location: index.php');
} else if ($_SESSION['role'] != 'admin') {
    header('location: index.php');
}

/*-------------- RECUPERATION DES TABLES DE DONNEES --------------*/
/* Requetes */
$sqlGrp = "select * from groupes";
$sqlConcert = "select * from concerts";
$sqlUsr = "select * from users";
$sqlGenre = "select * from genremusical";
$sqlReserv = "select * from reservations";

/* Envoie */
$groupes = $connexion->query($sqlGrp);
$concerts = $connexion->query($sqlConcert);
$users = $connexion->query($sqlUsr);
$genres = $connexion->query($sqlGenre);
$reservations = $connexion->query($sqlReserv);

/* Traitement */
$groupe = $groupes->fetchAll(PDO::FETCH_OBJ);
$concert = $concerts->fetchAll(PDO::FETCH_OBJ);
$user = $users->fetchAll(PDO::FETCH_OBJ);
$genremusique = $genres->fetchAll(PDO::FETCH_OBJ);
$reserv = $reservations->fetchAll(PDO::FETCH_OBJ);

/*-------------- VARIABLE ENREGISTREMENT DE FICHIER --------------*/
$enregistrement = false;
$aff="";

/*--------------     TRAITEMENT DES FORMULAIRES     --------------*/
// Traitement du formulaire pour AJOUTER UN CONCERT
if (isset($_POST['sendAjtConcert'])) {

    if (!empty($_POST['nomGroupe']) && !empty($_POST['date']) && !empty($_POST['lieu']) && !empty($_POST['prix'])) {

        // Stockage des valeurs
        $nomGroupe = htmlspecialchars($_POST['nomGroupe']);
        $date = htmlspecialchars($_POST['date']);
        $lieu = htmlspecialchars($_POST['lieu']);
        $prix = htmlspecialchars($_POST['prix']);

        // Requête et traitement
        $recupGroupe = "select * from groupes where nom = '$nomGroupe';";
        $idGrps = $connexion->query($recupGroupe);
        $idGrp = $idGrps->fetchAll(PDO::FETCH_ASSOC);

        // Si le nom du groupe correspond à la récupération de la requête
        if ($nomGroupe == $idGrp[0]['nom']) {

            $id = $idGrp[0]['id_groupe'];

            // Ajout du concert
            $sqlInsertConcert = "insert into concerts (groupe, lieu, date, prix_place) values ('$id', '$lieu', '$date', '$prix')";
            $insertConcert = $connexion->exec($sqlInsertConcert);

            $_SESSION['updateSite'] = 'AjtConcert';

            header('location:admin.php');

        } else {
            // Affichage de l'alerte
            echo '<body onload = "alert(\'Ce groupe n`existe pas \')" >';
        }

    } else {
        echo '<body onload = "alert(\'Les données du formulaire ne sont pas valables\')" >';
        echo '<meta http-equiv="refresh" content="0;URL=admin.php">';
    }

}
// Traitement du formulaire pour SUPPRIMER UN CONCERT
else if (isset($_POST['sendSprConcert'])) {

    if (!empty($_POST['nomGroupe']) && !empty($_POST['date']) && !empty($_POST['lieu'])) {

        // Stockage des valeurs
        $nomGroupe = htmlspecialchars($_POST['nomGroupe']);
        $date = htmlspecialchars($_POST['date']);
        $lieu = htmlspecialchars($_POST['lieu']);

        // requête et traiement
        $recupGroupe = "select * from groupes where nom = '$nomGroupe';";
        $idGrps = $connexion->query($recupGroupe);
        $idGrp = $idGrps->fetchAll(PDO::FETCH_ASSOC);

        // Si le nom correspond
        if ($nomGroupe == $idGrp[0]['nom']) {

            $id = $idGrp[0]['id_groupe'];

            // Récupération informations essentielles
            $sql = "select * from concerts where groupe = '$id' and date = '$date' and lieu = '$lieu';";
            $concert = $connexion->query($sql);

            if ($concert->rowCount() == 1) {
                // Suppression
                $sqlDeleteConcert = "delete from concerts where groupe = '$id' and date = '$date' and lieu = '$lieu';";
                $deleteConcert = $connexion->exec($sqlDeleteConcert);

                $_SESSION['updateSite'] = 'SprConcert';

                header('location:admin.php');

            } else {
                // Affichage de l'alerte
                echo '<body onload = "alert(\'Ce concert n`existe pas \')" >';
            }

        } else {
            echo '<body onload = "alert(\'Ce groupe n`eciste pas\')" >';
            echo '<meta http-equiv="refresh" content="0;URL=admin.php">';
        }

    } else {
        echo '<body onload = "alert(\'Les données du formulaire ne sont pas valable\')" >';
        echo '<meta http-equiv="refresh" content="0;URL=admin.php">';
    }

}
// Traitement du formulaire pour AJOUTER UN GROUPE/ARTISTE
else if (isset($_POST['sendAjtGrp'])) {

    if (!empty($_POST['nomGroupe']) && !empty($_POST['genre'])) {

        // Stockage des valeurs
        $nomGroupe = htmlspecialchars($_POST['nomGroupe']);
        $genre = htmlspecialchars($_POST['genre']);

        // Récupère les informations sur les genres de musique
        $recupGenre = "select * from genremusical where nomGenre = '$genre'";
        $genres = $connexion->query($recupGenre); // Envoie

        if ($genres->rowCount() === 1) {
            $nomGenre = $genres->fetchAll(PDO::FETCH_ASSOC);
            // Réaffectation de la variable
            $genre = $nomGenre[0]['nomGenre'];

            // ENREGISTREMENT DE L'IMAGE SUR LE SERVEUR
            if (isset($_FILES) && $_FILES['image']['error'] == 0) {
                $enregistrement = move_uploaded_file($_FILES["image"]["tmp_name"], "image/groupe/" . $_FILES["image"]["name"]);
                $aff .= "Stored in: " . "image/groupe/" . $_FILES["image"]["name"];
            }

            // INSERTION
            $image = 'image/groupe/'.$_FILES["image"]["name"];

            // Ajout du groupe
            $sql = "insert into groupes (nom, genre, image)
                    values ('$nomGroupe', '$genre', '$image')";

            $insertGroupe = $connexion->exec($sql);

            // Ajout variable de session
            $_SESSION['updateSite'] = 'AjtGroupe';

            // Redirection
            header('location:admin.php');

        } else {
            // Affichage de l'alerte
            echo '<body onload = "alert(\'Ce genre n`existe pas \')" >';
        }

    } else {
        echo '<body onload = "alert(\'Les données du formulaire ne sont pas valables\')" >';
        echo '<meta http-equiv="refresh" content="0;URL=admin.php">';
    }

}
// Traitement du formulaire pour SUPPRIMER UN GROUPE/ARTISTE
else if (isset($_POST['sendSprGrp'])) {

    if (isset($_POST['sendSprGrp'])) {

        if (!empty($_POST['nomGroupe']) && !empty($_POST['genre'])) {

            // Stockage des valeurs
            $nomGroupe = htmlspecialchars($_POST['nomGroupe']);
            $genre = htmlspecialchars($_POST['genre']);

            // Récupère les informations sur les genres de musique
            $recupGenre = "select * from genremusical where nomGenre = '$genre'";
            $genres = $connexion->query($recupGenre); // Envoie

            if ($genres->rowCount() === 1) {
                $nomGenre = $genres->fetchAll(PDO::FETCH_ASSOC);
                // Réaffectation de la variable
                $genre = $nomGenre[0]['nomGenre'];

                // Requête
                $sql = "select * from groupes where nom = '$nomGroupe';";
                $sprGroupe = $connexion->query($sql);

                if ($sprGroupe->rowCount() == 1) {
                    // Suppression
                    $sqlDeleteGrp = "delete from groupes where nom = '$nomGroupe' and genre = '$genre';";
                    $deleteGrp = $connexion->exec($sqlDeleteGrp);

                    $_SESSION['updateSite'] = 'SprGroupe';

                    header('location:admin.php');

                } else {
                    // Affichage de l'alerte
                    echo '<body onload = "alert(\'Ce groupe n`existe pas \')" >';
                }
            } else {
                // Affichage de l'alerte
                echo '<body onload = "alert(\'Ce genre n`existe pas \')" >';
            }

        } else {
            echo '<body onload = "alert(\'Les données du formulaire ne sont pas valables\')" >';
            echo '<meta http-equiv="refresh" content="0;URL=admin.php">';
        }

    } else {
        echo '<body onload = "alert(\'Les données du formulaire ne sont pas valables\')" >';
        echo '<meta http-equiv="refresh" content="0;URL=admin.php">';
    }

}
// Traitement du formulaire pour MODIFIER UN CONCERT
else if (isset($_POST['sendMdfConcert'])) {

    if (!empty($_POST['nomGroupe']) && !empty($_POST['lieu']) && !empty($_POST['date'])) {

        // Stockage des valeurs
        $nomGroupe = htmlspecialchars($_POST['nomGroupe']);
        $lieu = htmlspecialchars($_POST['lieu']);
        $date = htmlspecialchars($_POST['date']);

        // Requête et envoie
        $sql = "select * from concerts Cr join groupes Gr on Gr.id_groupe = Cr.groupe
                where Gr.nom = '$nomGroupe' and Cr.lieu = '$lieu' and Cr.date = '$date';";
        $recupConcert = $connexion->query($sql);

        if ($recupConcert->rowCount() == 1) {
            // Traitement
            $selectConcert = $recupConcert->fetchAll(PDO::FETCH_ASSOC);

            // Stockage des varialbes utiles pour la modification
            $_SESSION['idConcert'] = $selectConcert[0]['id_concert'];
            $_SESSION['id_groupe'] = $selectConcert[0]['groupe'];
        } else {
            echo '<body onload = "alert(\'Ce concert n`existe pas\')" >';
            echo '<meta http-equiv="refresh" content="0;URL=admin.php">';
        }

    } else {
        echo '<body onload = "alert(\'Les données du formulaire ne sont pas valables\')" >';
        echo '<meta http-equiv="refresh" content="0;URL=admin.php">';
    }
}
// TRAITEMENT DES MODIFICATIONS DU CONCERT
else if (isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == "modifCrt") {

    if (isset($_SESSION['idConcert']) && isset($_SESSION['id_groupe'])) {

        // Stockage des valeurs
        $idConcert = $_SESSION['idConcert'];
        $idGroup = $_SESSION['id_groupe'];

        // Requête
        $sql = "select * from concerts where id_concert = '$idConcert';";
        $recupConcert = $connexion->query($sql);

        if ($recupConcert->rowCount() == 1) {
            // Traitement de la requête
            $selectConcert = $recupConcert->fetchAll(PDO::FETCH_ASSOC);

            if (isset($_POST['modificationConcert'])) {

                if (!empty($_POST['nomGroupe']) && !empty($_POST['lieu']) && !empty($_POST['date']) && !empty($_POST['prix'])) {

                    // Stockage des valeurs
                    $nomGroupe = htmlspecialchars($_POST['nomGroupe']);
                    $lieu = htmlspecialchars($_POST['lieu']);
                    $date = htmlspecialchars($_POST['date']);
                    $prix = htmlspecialchars($_POST['prix']);

                    // Modification du concert
                    $updateConcert = "update concerts set groupe = '$idGroup', lieu = '$lieu', date = '$date', 
                                    prix_place = '$prix' where id_concert = '$idConcert';";

                    $update = $connexion->exec($updateConcert);

                    $_SESSION['updateSite'] = "modifConcert";

                    // Suppression des variables de session inutiles
                    unset($_SESSION['idConcert']);
                    unset($_SESSION['id_groupe']);

                    // Redirection
                    header('location: admin.php');

                } else {
                    echo '<body onload = "alert(\'Les données du formulaire ne sont pas valables\')" >';
                    echo '<meta http-equiv="refresh" content="0;URL=admin.php?action=modifCrt">';
                }
            } else {
                echo '<body onload = "alert(\'Les données du formulaire ne sont pas valables\')" >';
                echo '<meta http-equiv="refresh" content="0;URL=admin.php?action=modifCrt">';
            }
        } else {
            echo '<body onload = "alert(\'Concert inexistant\')" >';
            echo '<meta http-equiv="refresh" content="0;URL=admin.php">';
        }
    } else {
        echo '<body onload = "alert(\'Aucun concert séléctionné\')" >';
        echo '<meta http-equiv="refresh" content="0;URL=admin.php">';
    }
}
// Traitement du formulaire pour MODIFIER UN GROUPE/ARTISTE
else if (isset($_POST['sendMdfGrp']) && !empty($_POST['nomGroupe']) && !empty($_POST['genre'])) {

    // Stockage valeur
    $nomGroupe = htmlspecialchars($_POST['nomGroupe']);
    $genre = htmlspecialchars($_POST['genre']);

    // Requête et envoie
    $sql = "select * from groupes Gr join genremusical Gm on Gm.id_genre = Gr.genre where Gr.nom = '$nomGroupe' and Gm.nomGenre = '$genre';";
    $recupGrp = $connexion->query($sql);

    if ($recupGrp->rowCount() == 1) {
        // Traitement de la requête
        $selectGrp = $recupGrp->fetchAll(PDO::FETCH_ASSOC);

        // Stockage valeur utile pour la modification
        $_SESSION['id_groupe'] = $selectGrp[0]['id_groupe'];

    } else {
        echo '<body onload = "alert(\'Ce groupe ou ce genre n`existe pas\')" >';
        echo '<meta http-equiv="refresh" content="0;URL=admin.php">';
    }
}
// TRAITEMENT DES MODIFICATIONS DU GROUPE
else if (isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == "modifGrp") {

    if (isset($_SESSION['id_groupe'])) {

        // Stockage valeur
        $idGroupe = $_SESSION['id_groupe'];

        // Requête
        $sql = "select * from groupes where id_groupe = '$idGroupe';";
        $recupGrp = $connexion->query($sql);

        if ($recupGrp->rowCount() == 1) {

            // Traitement de la requête
            $selectGrp = $recupGrp->fetchAll(PDO::FETCH_ASSOC);

            if (isset($_POST['modificationGrp']) && !empty($_POST['nomGroupe']) && !empty($_POST['genre'])) {

                // Stockage valeur
                $nomGroupe = htmlspecialchars($_POST['nomGroupe']);
                $genre = htmlspecialchars($_POST['genre']);

                // Requête
                $sql = "select * from genremusical where nomGenre = '$genre';";
                $id_genres = $connexion->query($sql); // Envoie

                if ($id_genres->rowCount() > 0) {
                    $id_genre = $id_genres->fetchAll(PDO::FETCH_ASSOC);

                    $genre = $id_genre[0]['id_genre'];

                    // ENREGISTREMENT DE L'IMAGE
                    if (isset($_FILES) && $_FILES['image']['error'] == 0) {
                        $enregistrement = move_uploaded_file($_FILES["image"]["tmp_name"], "image/groupe/" . $_FILES["image"]["name"]);
                        $aff .= "Stored in: " . "image/groupe/" . $_FILES["image"]["name"];
                    }

                    // INSERTION
                    $image = 'image/groupe/' . $_FILES["image"]["name"];

                    // Modification du groupe
                    $updateGrp = "update groupes set nom = '$nomGroupe', genre = '$genre', image = '$image' where id_groupe = '$idGroupe';";

                    $update = $connexion->exec($updateGrp);

                    $_SESSION['updateSite'] = "modifGroupe";

                    // Suppression des variables de session inutiles
                    unset($_SESSION['id_groupe']);
                    unset($_POST['modificationGrp']);

                    // redirection
                    header('location: admin.php');
                } else {
                    echo '<body onload = "alert(\'Ce genre n`existe pas\')" >';
                    echo '<meta http-equiv="refresh" content="URL=admin.php?action=modifGrp">';
                }
            } else {
                echo '<body onload = "alert(\'Les données du formulaires ne sont pas valables\')" >';
                echo '<meta http-equiv="refresh" content="0;URL=admin.php?action=modifGrp">';
            }
        } else {
            echo '<body onload = "alert(\'Ce groupe n`existe pas !\')" >';
            echo '<meta http-equiv="refresh" content="0;URL=admin.php">';
        }
    } else {
        echo '<body onload = "alert(\'Aucun groupe séléctionné\')" >';
        echo '<meta http-equiv="refresh" content="0;URL=admin.php">';
    }
}
// Traitement du formulaire pour AJOUTER UN GENRE
else if (isset($_POST['sendAjtGenre']) && !empty($_POST['genre'])) {

    // Stockage des valeurs
    $genre = htmlspecialchars($_POST['genre']);

    $recupGenre = "select * from genremusical where nomGenre = '$genre';";   // Requête
    $genres = $connexion->query($recupGenre);

    if ($genres->rowCount() == 0) {

        $sql = "insert into genremusical (nomGenre) values ('$genre');";
        $insertGenre = $connexion->exec($sql);

        $_SESSION['updateSite'] = "AjtGenre";

        header('location: admin.php');

    } else {
        echo '<body onload = "alert(\'Ce genre existe déjà !\')" >';
        echo '<meta http-equiv="refresh" content="0;URL=admin.php">';
    }

}
// Traitement du formulaire poour SUPPRIMER UN GENRE
else if (isset($_POST['sendSprGenre']) && !empty($_POST['genre'])) {

    // Stockage variable
    $genre = htmlspecialchars($_POST['genre']);

    // Requête
    $recupGenre = "select * from genremusical where nomGenre = '$genre';";
    $genres = $connexion->query($recupGenre);

    if ($genres->rowCount() === 1) {

        $sql = "delete from genremusical where nomGenre = '$genre';";
        $deleteGenre = $connexion->exec($sql);

        $_SESSION['updateSite'] = "SprGenre";

        header('location: admin.php');

    } else {
        echo '<body onload = "alert(\'Ce genre n`existe pas\')" >';
        echo '<meta http-equiv="refresh" content="0;URL=admin.php">';
    }

}
// Traitement du formulaire pour MODIFIER UN GENRE
else if (isset($_POST['sendMdfGenre']) && isset($_POST['genre']) && !empty($_POST['genre'])) {

    // Stockage variable
    $genre = htmlspecialchars($_POST['genre']);

    // Requête
    $recupGenre = "select * from genremusical where nomGenre = '$genre';";
    $genres = $connexion->query($recupGenre);

    if ($genres->rowCount() === 1) {

        // Traitement de la requête
        $genre = $genres->fetchAll(PDO::FETCH_ASSOC);

        // Stockage valeur utile pour la modification
        $_SESSION['id_genre'] = $genre[0]['id_genre'];

    } else {
        echo '<body onload = "alert(\'Ce genre n`existe pas\')" >';
        echo '<meta http-equiv="refresh" content="0;URL=admin.php">';
    }

}
// TRAITEMENT DES MODIFICATIONS DU GROUPE
else if (isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == "modifGenre") {

    if (isset($_SESSION['id_genre'])) {

        $idGenre = htmlspecialchars($_SESSION['id_genre']);

        // Requête
        $sql = "select * from genremusical where id_genre = '$idGenre';";
        $recupGenre = $connexion->query($sql);

        if ($recupGenre->rowCount() === 1) {

            // Traitement de la requête
            $genre = $recupGenre->fetchAll(PDO::FETCH_ASSOC);

            if (isset($_POST['modificationGenre']) && !empty($_POST['genre'])) {

                $nomGenre = htmlspecialchars($_POST['genre']);

                $updateGenre = "update genremusical set nomGenre = '$nomGenre' where id_genre = '$idGenre';";

                $update = $connexion->exec($updateGenre);

                $_SESSION['updateSite'] = "modifGenre";

                // Suppression des variables de session inutiles
                unset($_SESSION['id_genre']);

                // redirection
                header('location: admin.php');

            } else {
                echo '<body onload = "alert(\'Les données du formulaire ne sont pas valides\')" >';
                echo '<meta http-equiv="refresh" content="0;URL=admin.php?action=modifGenre">';
            }

        } else {
            echo '<body onload = "alert(\'Ce groupe n`existe pas\')" >';
            echo '<meta http-equiv="refresh" content="0;URL=admin.php">';
        }
    } else {
        echo '<body onload = "alert(\'Aucun groupe séléctionné\')" >';
        echo '<meta http-equiv="refresh" content="0;URL=admin.php">';
    }

} else if (isset($_POST['annulReserv']) && isset($_POST['idRes']) && !empty($_POST['idRes'])) {

    $idRes = htmlspecialchars($_POST['idRes']);

    $sql = "select * from reservations where id_res ='$idRes';";
    $reserv = $connexion->query($sql);

    if ($reserv->rowCount() === 1) {

        $res = $reserv->fetchAll(PDO::FETCH_OBJ);

        $deleteRes = "delete from reservations where id_res = '$idRes';";
        $deleteRes = $connexion->exec($deleteRes);

        header('location: admin.php');

    }
}

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
        <script src="js/admin.js"></script>
        <title> Concertôt </title>
    </head>

    <body>
        <?php require('utils/header.php'); ?>

        <h2 id="titre-Admin"> Administration du site </h2>

        <!-- ===============================
             BOUTONS D'ACTION DE LA PAGE ADMIN
             =============================== -->

        <section id="action_admin">
            <h3 class="ss_titre"> Veuillez choisir l'action que vous voulez effectuer </h3>

            <div id="btn_admin">
                <div id="btn_concert">
                    <input type="button" id="ajout_concert" name="ajout_concert" value="Ajouter un concert">
                    <input type="button" id="suppr_concert" name="suppr_concert" value="Supprimer un concert">
                    <input type="button" id="modif_concert" name="modif_concert" value="Modifier un concert">
                </div>
                <div id="btn_groupe">
                    <input type="button" id="ajout_groupe" name="ajout_groupe" value="Ajouter un groupe">
                    <input type="button" id="suppr_groupe" name="suppr_groupe" value="Supprimer un groupe">
                    <input type="button" id="modif_groupe" name="modif_groupe" value="Modifier un groupe">
                </div>
                <div id="btn_genre">
                    <input type="button" id="ajout_genre" name="ajout_genre" value="Ajouter un genre">
                    <input type="button" id="suppr_genre" name="suppr_genre" value="Supprimer un genre">
                    <input type="button" id="modif_genre" name="modif_genre" value="Modifier un genre">
                </div>
            </div>

            <!-- ============ NOTIFICATIONS ============ -->

            <?php if (isset($_SESSION['updateSite']) && !empty($_SESSION['updateSite'])): ?>
                <?php if ($_SESSION['updateSite'] == 'AjtConcert') : ?>
                    <p class="info-admin"> Le concert à été ajouté avec succés ! </p>
                <?php elseif ($_SESSION['updateSite'] == 'SprConcert') : ?>
                    <p class="info-admin"> Le concert à été supprimé avec succés ! </p>
                <?php elseif ($_SESSION['updateSite'] == 'AjtGroupe') : ?>
                    <p class="info-admin"> Le groupe à été ajouté avec succés ! </p>
                <?php elseif ($_SESSION['updateSite'] == 'SprGroupe') : ?>
                    <p class="info-admin"> Le groupe à été supprimé avec succés ! </p>
                <?php elseif ($_SESSION['updateSite'] == "modifConcert") : ?>
                    <p class="info-admin"> Un concert vient d'être modifié avec succés ! </p>
                <?php elseif ($_SESSION['updateSite'] == "modifGroupe") : ?>
                    <p class="info-admin"> Un groupe vient d'être modifié avec succés ! </p>
                <?php elseif ($_SESSION['updateSite'] == "AjtGenre") : ?>
                    <p class="info-admin"> Un genre vient d'être ajouté avec succés ! </p>
                <?php elseif ($_SESSION['updateSite'] == "SprGenre") : ?>
                    <p class="info-admin"> Un genre vient d'être supprimé avec succés ! </p>
                <?php elseif ($_SESSION['updateSite'] == "modifGenre") : ?>
                    <p class="info-admin"> Un genre vient d'être modifié avec succés ! </p>
                <?php endif; ?>
            <?php endif; ?>

        </section>

        <!-- ===============================
             INSERTION DES TABLES DE DONNEES
             =============================== -->

        <div id="table_status">
            <table class="table_admin groupes">

                <!-- ============ TABLE GROUPES ============ -->

                <h3> Table groupes </h3>

                <tr>
                    <th> Id </th>
                    <th> Nom </th>
                    <th> Genre </th>
                    <th> Image </th>
                </tr>

                <?php foreach ($groupe as $unGrp): ?>
                    <tr>
                        <td> <?= $unGrp->id_groupe ?> </td>
                        <td> <?= $unGrp->nom; ?> </td>
                        <td> <?= $unGrp->genre; ?> </td>
                        <td> <?= $unGrp->image; ?> </td>
                    </tr>
                <?php endforeach; ?>

            </table>

            <table class="table_admin concerts">

                <!-- ============ TABLE CONCERTS ============ -->

                <h3> Table concerts </h3>

                <tr>
                    <th> Id </th>
                    <th> Id_groupe </th>
                    <th> Lieu </th>
                    <th> Date </th>
                    <th> Prix </th>
                </tr>

                <?php foreach ($concert as $unConcert): ?>
                    <tr>
                        <td> <?= $unConcert->id_concert; ?> </td>
                        <td> <?= $unConcert->groupe; ?> </td>
                        <td> <?= $unConcert->lieu; ?> </td>
                        <td> <?= $unConcert->date; ?> </td>
                        <td> <?= $unConcert->prix_place; ?> </td>
                    </tr>
                <?php endforeach; ?>

            </table>

            <table class="table_admin genreMusique">

                <!-- ============ TABLE GENRES ============ -->

                <h3> Table genreMusical </h3>

                <tr>
                    <th> Id </th>
                    <th> Genre </th>
                </tr>

                <?php foreach ($genremusique as $unGenre): ?>
                    <tr>
                        <td> <?= $unGenre->id_genre ?> </td>
                        <td> <?= $unGenre->nomGenre; ?> </td>
                    </tr>
                <?php endforeach; ?>

            </table>

            <table class="table_admin users">

                <!-- ============ TABLE USERS ============ -->

                <h3> Table users </h3>

                <tr>
                    <th> Id </th>
                    <th> Login </th>
                </tr>

                <?php foreach ($user as $unUsr): ?>
                    <tr>
                        <td> <?= $unUsr->id_user; ?> </td>
                        <td> <?= $unUsr->login; ?> </td>
                    </tr>
                <?php endforeach; ?>

            </table>

            <table class="table_admin reservation">

                <!-- ============ TABLE RESERVATIONS ============ -->

                <h3> Table reservations </h3>

                <tr>
                    <th> Id </th>
                    <th> idUser </th>
                    <th> idConcert </th>
                    <th> Nombre place </th>
                    <th> PrixTotal </th>
                    <th> idGroupe </th>
                    <th> Lieu </th>
                    <th> Date </th>
                    <th> </th>
                </tr>

                <?php foreach ($reserv as $uneReserv): ?>
                    <tr>
                        <td> <?= $uneReserv->id_res; ?> </td>
                        <td> <?= $uneReserv->idUser; ?> </td>
                        <td> <?= $uneReserv->idConcert; ?> </td>
                        <td> <?= $uneReserv->nbPlace; ?> </td>
                        <td> <?= $uneReserv->prixTotal; ?> </td>
                        <td> <?= $uneReserv->groupe; ?> </td>
                        <td> <?= $uneReserv->lieu; ?> </td>
                        <td> <?= $uneReserv->date; ?> </td>
                        <td id="btnAnnulReserv">
                            <form action="admin.php" method="post">
                                <input type="hidden" name="idRes" value="<?= $uneReserv->id_res ?>">
                                <input type="submit" name="annulReserv" value="X">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </table>
        </div>

        <!-- ===============================
             FORMULAIRE D'AJOUT D'UN CONCERT
             =============================== -->

        <form action="admin.php" id="ajoutConcert" class="formulaire" method="post">
            <fieldset id="form-ajout">
                <legend>Ajout d'un concert</legend>
                <p>
                    <label for="nomGroupe"> Nom du groupe: </label>
                    <input type="text" name="nomGroupe" id="nomGroupe" required>
                </p>
                <p>
                    <label for="dateGroupe"> Date du concert : </label>
                    <input type="date" name="date" id="dateGroupe" required>
                </p>
                <p>
                    <label for="lieuGroupe"> Lieu du concert : </label>
                    <input type="text" name="lieu" id="lieuGroupe" required>
                </p>
                <p>
                    <label for="prixConcert"> Prix de la place : </label>
                    <input type="text" name="prix" id="prixConcert" required>
                </p>
            </fieldset>

            <p class="submit">
                <input type="submit" id="btnSubmit" value="Continuer" name="sendAjtConcert"/>
                <input type="reset" id="btnReset" value="Annuler"/>
            </p>
        </form>

        <!-- ===============================
             FORMULAIRE SUPPRESSION D'UN CONCERT
             =============================== -->

        <form action="admin.php" id="supprConcert" class="formulaire" method="post">
            <fieldset id="form-ajout">
                <legend>Supprimer d'un concert</legend>
                <p>
                    <label for="nomGroupe"> Nom du groupe : </label>
                    <input type="text" name="nomGroupe" id="nomGroupe" required>
                </p>
                <p>
                    <label for="dateGroupe"> Date du concert : </label>
                    <input type="date" name="date" id="dateGroupe" required>
                </p>
                <p>
                    <label for="lieuGroupe"> Lieu du concert : </label>
                    <input type="text" name="lieu" id="lieuGroupe" required>
                </p>
            </fieldset>

            <p class="submit">
                <input type="submit" id="btnSubmit" value="Continuer" name="sendSprConcert"/>
                <input type="reset" id="btnReset" value="Annuler"/>
            </p>
        </form>

        <!-- ===============================
             FORMULAIRE D'AJOUT D'UN GROUPE
             =============================== -->

        <form action="admin.php" id="ajoutGroupe" class="formulaire" method="post" enctype="multipart/form-data">
            <fieldset id="form-ajout">
                <legend>Ajout d'un groupe</legend>
                <p>
                    <label for="nomGroupe"> Nom : </label>
                    <input type="text" name="nomGroupe" id="nomGroupe" required>
                </p>
                <p>
                    <label for="genre"> Genre: </label>
                    <input type="text" name="genre" id="genre" required>
                </p>
                <p>
                    <label for="img-groupe"> Image du groupe : </label>
                    <input type="file" name="image" accept="image/jpeg" required>
                </p>
            </fieldset>

            <p class="submit">
                <input type="submit" id="btnSubmit" value="Continuer" name="sendAjtGrp"/>
                <input type="reset" id="btnReset" value="Annuler"/>
            </p>
        </form>

        <!-- ===============================
             FORMULAIRE SUPPRESSION D'UN GROUPE
             =============================== -->

        <form action="admin.php" id="supprGroupe" class="formulaire" method="post">
            <fieldset id="form-ajout">
                <legend>Suppression d'un groupe</legend>
                <p>
                    <label for="nomGroupe"> Nom : </label>
                    <input type="text" name="nomGroupe" id="nomGroupe" required>
                </p>
                <p>
                    <label for="genre"> Genre : </label>
                    <input type="text" name="genre" id="genre" required>
                </p>
            </fieldset>

            <p class="submit">
                <input type="submit" id="btnSubmit" value="Continuer" name="sendSprGrp"/>
                <input type="reset" id="btnReset" value="Annuler"/>
            </p>
        </form>

        <!-- ===============================
             FORMULAIRE MODIFICATION D'UN CONCERT
             =============================== -->

        <form action="admin.php?action=modifCrt" id="modifConcert" class="formulaire" method="post">
            <fieldset id="form-ajout">
                <?php if (isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == "modifCrt") : ?>
                    <legend> Modification du concert </legend>
                <?php else : ?>
                    <legend> Sélection d'un concert</legend>
                <?php endif; ?>
                <p>
                    <label for="nomGroupe"> Nom du groupe : </label>
                    <input type="text" name="nomGroupe" id="nomGroupe" required>
                </p>
                <p>
                    <label for="lieu"> Lieu : </label>
                    <input type="text" name="lieu" id="lieu" required>
                </p>
                <p>
                    <label for="date"> Date : </label>
                    <input type="date" name="date" id="date" required>
                </p>
                <?php if (isset($_GET['action']) && $_GET['action'] == "modifCrt") : ?>
                <p>
                    <label for="prix"> Nouveau prix: </label>
                    <input type="text" name="prix" id="prix" required>
                </p>
                <?php endif; ?>
            </fieldset>

            <p class="submit">
                <input type="submit" id="btnSubmit" value="Continuer"
                    <?php if (isset($_GET['action']) && $_GET['action'] == "modifCrt") : ?>
                        name="modificationConcert"
                    <?php else : ?>
                        name="sendMdfConcert"
                    <?php endif; ?>
                />
                <input type="reset" id="btnReset" value="Annuler"/>
            </p>
        </form>

        <!-- ===============================
             FORMULAIRE MODIFICATION D'UN GROUPE
             =============================== -->

        <form action="admin.php?action=modifGrp" id="modifGroupe" class="formulaire" method="post" enctype="multipart/form-data">
            <fieldset id="form-ajout">
                <?php if (isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == "modifGrp") : ?>
                    <legend> Modification du groupe </legend>
                <?php else : ?>
                    <legend> Sélection d'un groupe </legend>
                <?php endif; ?>
                <p>
                    <label for="nomGroupe"> Nom : </label>
                    <input type="text" name="nomGroupe" id="nomGroupe" required>
                </p>
                <p>
                    <label for="genre"> Genre musical : </label>
                    <input type="text" name="genre" id="genre" required>
                </p>
                <?php if (isset($_GET['action']) && $_GET['action'] == "modifGrp") : ?>
                    <p>
                        <label for="image"> Image du groupe : </label>
                        <input type="file" name="image" accept="image/jpeg" required>
                    </p>
                <?php endif; ?>
            </fieldset>

            <p class="submit">
                <input type="submit" id="btnSubmit" value="Continuer"
                    <?php if (isset($_GET['action']) && $_GET['action'] == "modifGrp") : ?>
                        name="modificationGrp"
                    <?php else : ?>
                        name="sendMdfGrp"
                    <?php endif; ?>
                />
                <input type="reset" id="btnReset" value="Annuler"/>
            </p>
        </form>

        <!-- ===============================
             FORMULAIRE AJOUT D'UN GENRE
             =============================== -->

        <form action="admin.php" id="ajoutGenre" class="formulaire" method="post">
            <fieldset id="form-ajout">
                <legend> Ajout d'un genre de musique </legend>
                <p>
                    <label for="nomGenre"> Nom du genre : </label>
                    <input type="text" name="genre" id="nomGenre" required>
                </p>
            </fieldset>

            <p class="submit">
                <input type="submit" id="btnSubmit" value="Ajouter" name="sendAjtGenre"/>
                <input type="reset" id="btnReset" value="Annuler"/>
            </p>
        </form>

        <!-- ===============================
             FORMULAIRE SUPPRESSION D'UN GENRE
             =============================== -->

        <form action="admin.php" id="supprGenre" class="formulaire" method="post">
            <fieldset id="form-ajout">
                <legend> Suppression d'un genre de musique </legend>
                <p>
                    <label for="nomGenre"> Nom du genre : </label>
                    <input type="text" name="genre" id="nomGenre" required>
                </p>
            </fieldset>

            <p class="submit">
                <input type="submit" id="btnSubmit" value="Continuer" name="sendSprGenre"/>
                <input type="reset" id="btnReset" value="Annuler"/>
            </p>
        </form>

        <!-- ===============================
             FORMULAIRE MODIFICATION D'UN GENRE
             =============================== -->

        <form action="admin.php?action=modifGenre" id="modifGenre" class="formulaire" method="post">
            <fieldset id="form-ajout">
                <?php if (isset($_GET['action']) && !empty($_GET['action']) && $_GET['action'] == "modifGenre") : ?>
                    <legend> Modification d'un genre de musique </legend>
                <?php else : ?>
                    <legend> Sélection d'un genre de musique </legend>
                <?php endif; ?>
                <p>
                    <label for="nomGenre"> Nom du genre : </label>
                    <input type="text" name="genre" id="nomGenre" required >
                </p>

            </fieldset>

            <p class="submit">
                <input type="submit" id="btnSubmit" value="Continuer"
                    <?php if (isset($_GET['action']) && $_GET['action'] == "modifGenre") : ?>
                        name="modificationGenre"
                    <?php else : ?>
                       name="sendMdfGenre"
                    <?php endif; ?>
                />
                <input type="reset" id="btnReset" value="Annuler"/>
            </p>
        </form>

        <?php require('utils/footer.php'); ?>
    </body>
</html>
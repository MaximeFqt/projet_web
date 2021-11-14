<?php

session_start();

// Inclusion du fichier
include('connexion.php');
$connexion = connexionBd();

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

/* Envoie */
$groupes = $connexion->query($sqlGrp);
$concerts = $connexion->query($sqlConcert);
$users = $connexion->query($sqlUsr);

/* Traitement */
$groupe = $groupes->fetchAll(PDO::FETCH_OBJ);
$concert = $concerts->fetchAll(PDO::FETCH_OBJ);
$user = $users->fetchAll(PDO::FETCH_OBJ);

/*-------------- VARIABLE ENREGISTREMENT DE FICHIER --------------*/
$enregistrement = false;
$aff="";

/*--------------     TRAITEMENT DES FORMULAIRES     --------------*/
// Traitement du formulaire pour ajouter un concert
if (isset($_POST['sendAjtConcert'])) {

    if (!empty($_POST['nomGroupe']) && !empty($_POST['date']) && !empty($_POST['lieu']) && !empty($_POST['prix'])) {

        // Stockage des valeurs
        $nomGroupe = htmlspecialchars($_POST['nomGroupe']);
        $date = htmlspecialchars($_POST['date']);
        $lieu = htmlspecialchars($_POST['lieu']);
        $prix = htmlspecialchars($_POST['prix']);

        $recupGroupe = "select * from groupes where nom = '$nomGroupe';";
        $idGrps = $connexion->query($recupGroupe);
        $idGrp = $idGrps->fetchAll(PDO::FETCH_ASSOC);

        if ($nomGroupe == $idGrp[0]['nom']) {

            $id = $idGrp[0]['id_groupe'];

            $sqlInsertConcert = "insert into concerts (groupe, lieu, date, prix_place) values ('$id', '$lieu', '$date', '$prix')";
            $insertConcert = $connexion->exec($sqlInsertConcert);

            $_SESSION['updateSite'] = 'AjtConcert';

        } else {
            // Affichage de l'alerte
            echo '<body onload = "alert(\'Ce groupe n`existe pas \')" >';
        }

    }

}
// Traitement du formulaire pour supprimer un concert
else if (isset($_POST['sendSprConcert'])) {

    if (!empty($_POST['nomGroupe']) && !empty($_POST['date']) && !empty($_POST['lieu'])) {

        // Stockage des valeurs
        $nomGroupe = htmlspecialchars($_POST['nomGroupe']);
        $date = htmlspecialchars($_POST['date']);
        $lieu = htmlspecialchars($_POST['lieu']);

        $recupGroupe = "select * from groupes where nom = '$nomGroupe';";
        $idGrps = $connexion->query($recupGroupe);
        $idGrp = $idGrps->fetchAll(PDO::FETCH_ASSOC);

        if ($nomGroupe == $idGrp[0]['nom']) {

            $id = $idGrp[0]['id_groupe'];

            $sql = "select * from concerts where groupe = '$id' and date = '$date' and lieu = '$lieu';";
            $concert = $connexion->query($sql);

            if ($concert->rowCount() == 1) {
                $sqlDeleteConcert = "delete from concerts where groupe = '$id' and date = '$date' and lieu = '$lieu';";
                $insertConcert = $connexion->exec($sqlDeleteConcert);

                $_SESSION['updateSite'] = 'SprConcert';
            } else {
                // Affichage de l'alerte (font de la page est la page ajoutUser.php)
                echo '<body onload = "alert(\'Ce concert n`existe pas \')" >';
            }

        }

    }

}
// Traitement du formulaire pour ajouter un groupe/artiste
else if (isset($_POST['sendAjtGrp'])) {

    if (!empty($_POST['nomGroupe'])) {

        // Stockage des valeurs
        $nomGroupe = htmlspecialchars($_POST['nomGroupe']);

        // ENREGISTREMENT DE L'IMAGE SUR LE SERVEUR
        if (isset($_FILES) && $_FILES['image']['error'] == 0) {
            $enregistrement = move_uploaded_file($_FILES["image"]["tmp_name"], "image/groupe/" . $_FILES["image"]["name"]);
            $aff .= "Stored in: " . "image/groupe/" . $_FILES["image"]["name"];
        }

        // INSERTION
        $image = 'image/groupe/'.$_FILES["image"]["name"];

        $sql = "insert into groupes (nom, image)
                    values ('$nomGroupe', '$image')";

        $insertArticle = $connexion->exec($sql);

        $_SESSION['updateSite'] = 'AjtGroupe';

    }

}
// Traitement du formulaire pour supprimer un groupe/artiste
else if (isset($_POST['sendSprGrp'])) {

    if (isset($_POST['sendSprGrp'])) {

        if (!empty($_POST['nomGroupe'])) {

            $nomGroupe = htmlspecialchars($_POST['nomGroupe']);

            $sql = "select * from groupes where nom = '$nomGroupe';";
            $sprGroupe = $connexion->query($sql);

            if ($sprGroupe->rowCount() == 1) {
                $sqlDeleteGrp = "delete from groupes where nom = '$nomGroupe';";
                $insertConcert = $connexion->exec($sqlDeleteGrp);

                $_SESSION['updateSite'] = 'SprGroupe';

            } else {
                // Affichage de l'alerte (font de la page est la page ajoutUser.php)
                echo '<body onload = "alert(\'Ce groupe n`existe pas \')" >';
            }

        }

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
        <title>TrouvesTonConcert</title>
    </head>

    <body>
        <?php require('header.php'); ?>

        <h2 id="titre-Admin">Administration du site</h2>

        <!-- ===============================
             BOUTONS D'ACTION DE LA PAGE ADMIN
             =============================== -->

        <section id="action_admin">
            <h3 class="ss_titre"> Veuillez choisir l'action que vous voulez effectuer </h3>

            <div>
                <input type="button" id="ajout_concert" name="ajout_concert" value="Ajouter un concert">
                <input type="button" id="suppr_concert" name="suppr_concert" value="Supprimer un concert">
                <input type="button" id="ajout_groupe"  name="ajout_groupe"  value="Ajouter un groupe">
                <input type="button" id="suppr_groupe"  name="suppr_groupe"  value="Supprimer un groupe">
            </div>

            <?php if (isset($_SESSION['updateSite']) && !empty($_SESSION['updateSite'])): ?>
                <?php if ($_SESSION['updateSite'] == 'AjtConcert') : ?>
                    <p class="info-admin"> Le concert à été ajouté </p>
                <?php elseif ($_SESSION['updateSite'] == 'SprConcert') : ?>
                    <p class="info-admin"> Le concert à été supprimé </p>
                <?php elseif ($_SESSION['updateSite'] == 'AjtGroupe') : ?>
                    <p class="info-admin"> Le groupe à été ajouté </p>
                <?php elseif ($_SESSION['updateSite'] == 'SprGroupe') : ?>
                    <p class="info-admin"> Le groupe à été supprimé </p>
                <?php endif; ?>
            <?php endif; ?>

        </section>

        <div id="table_status">
            <table id="groupes">
                <h3> Table groupes </h3>

                <tr>
                    <td> Id </td>
                    <td> Nom </td>
                    <td> Image </td>
                </tr>

                <?php foreach ($groupe as $unGrp): ?>
                    <tr>
                        <td> <?= $unGrp->id_groupe ?> </td>
                        <td> <?= $unGrp->nom; ?> </td>
                        <td> <?= $unGrp->image; ?> </td>
                    </tr>
                <?php endforeach; ?>

            </table>

            <table id="concerts">

                <h3> Table concerts </h3>

                <tr>
                    <td> Id </td>
                    <td> Id_groupe </td>
                    <td> Lieu </td>
                    <td> Date </td>
                    <td> Prix </td>
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

            <table id="users">

                <h3> Table users </h3>

                <tr>
                    <td> Id </td>
                    <td> Login </td>
                </tr>

                <?php foreach ($user as $unUsr): ?>
                    <tr>
                        <td> <?= $unUsr->id_user; ?> </td>
                        <td> <?= $unUsr->login; ?> </td>
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
                    <label for="nom-groupe"> Nom du groupe: </label>
                    <input type="text" name="nomGroupe" required>
                </p>
                <p>
                    <label for="date-groupe"> Date du concert : </label>
                    <input type="date" name="date" required>
                </p>
                <p>
                    <label for="lieu-groupe"> Lieu du concert : </label>
                    <input type="text" name="lieu" required>
                </p>
                <p>
                    <label for="prix-concert"> Prix de la place : </label>
                    <input type="text" name="prix" required>
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
                    <label for="nom-groupe"> Nom du groupe : </label>
                    <input type="text" name="nomGroupe" required>
                </p>
                <p>
                    <label for="date-groupe"> Date du concert : </label>
                    <input type="date" name="date" required>
                </p>
                <p>
                    <label for="lieu-groupe"> Lieu du concert : </label>
                    <input type="text" name="lieu" required>
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
                    <label for="nom-groupe"> Nom : </label>
                    <input type="text" name="nomGroupe" required>
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
                    <label for="nom-groupe"> Nom : </label>
                    <input type="text" name="nomGroupe" required>
                </p>
            </fieldset>

            <p class="submit">
                <input type="submit" id="btnSubmit" value="Continuer" name="sendSprGrp"/>
                <input type="reset" id="btnReset" value="Annuler"/>
            </p>
        </form>


        <?php require('footer.php'); ?>
    </body>
</html>
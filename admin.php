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
                // Affichage de l'alerte (font de la page est la page ajoutUser.php)
                echo '<body onload = "alert(\'Ce concert n`existe pas \')" >';
            }

        }

    }

}
// Traitement du formulaire pour AJOUTER UN GROUPE/ARTISTE
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

        // Ajout du groupe
        $sql = "insert into groupes (nom, image)
                    values ('$nomGroupe', '$image')";

        $insertGroupe = $connexion->exec($sql);

        $_SESSION['updateSite'] = 'AjtGroupe';

        header('location:admin.php');

    }

}
// Traitement du formulaire pour SUPPRIMER UN GROUPE/ARTISTE
else if (isset($_POST['sendSprGrp'])) {

    if (isset($_POST['sendSprGrp'])) {

        if (!empty($_POST['nomGroupe'])) {

            // Stockage des valeurs
            $nomGroupe = htmlspecialchars($_POST['nomGroupe']);

            // Requête
            $sql = "select * from groupes where nom = '$nomGroupe';";
            $sprGroupe = $connexion->query($sql);

            if ($sprGroupe->rowCount() == 1) {
                // Suppression
                $sqlDeleteGrp = "delete from groupes where nom = '$nomGroupe';";
                $deleteGrp = $connexion->exec($sqlDeleteGrp);

                $_SESSION['updateSite'] = 'SprGroupe';

                header('location:admin.php');

            } else {
                // Affichage de l'alerte (font de la page est la page ajoutUser.php)
                echo '<body onload = "alert(\'Ce groupe n`existe pas \')" >';
            }

        }

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
            header('location: admin.php');
        }

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

                }
            }
        }
    } else { header('location: admin.php'); }
}
// Traitement du formulaire pour MODIFIER UN GROUPE/ARTISTE
else if (isset($_POST['sendMdfGrp']) && !empty($_POST['nomGroupe'])) {

    // Stockage valeur
    $nomGroupe = htmlspecialchars($_POST['nomGroupe']);

    // Requête et envoie
    $sql = "select * from groupes where nom = '$nomGroupe';";
    $recupGrp = $connexion->query($sql);

    if ($recupGrp->rowCount() == 1) {
        // Traitement de la requête
        $selectGrp = $recupGrp->fetchAll(PDO::FETCH_ASSOC);

        // Stockage valeur utile pour la modification
        $_SESSION['id_groupe'] = $selectGrp[0]['id_groupe'];

    } else {
        header('location: admin.php');
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

            if (isset($_POST['modificationGrp']) && !empty($_POST['nomGroupe'])) {

                // Stockage valeur
                $nomGroupe = htmlspecialchars($_POST['nomGroupe']);

                // ENREGISTREMENT DE L'IMAGE
                if (isset($_FILES) && $_FILES['image']['error'] == 0) {
                    $enregistrement = move_uploaded_file($_FILES["image"]["tmp_name"], "image/groupe/" . $_FILES["image"]["name"]);
                    $aff .= "Stored in: " . "image/groupe/" . $_FILES["image"]["name"];
                }

                // INSERTION
                $image = 'image/groupe/' . $_FILES["image"]["name"];

                // Modification du groupe
                $updateGrp = "update groupes set nom = '$nomGroupe', image = '$image' where id_groupe = '$idGroupe';";

                $update = $connexion->exec($updateGrp);

                $_SESSION['updateSite'] = "modifGroupe";

                // Suppression des variables de session inutiles
                unset($_SESSION['id_groupe']);
                unset($_POST['modificationGrp']);

                // redirection
                header('location: admin.php');

            }
        }
    } else {
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
        <title>TrouvesTonConcert</title>
    </head>

    <body>
        <?php require('header.php'); ?>

        <h2 id="titre-Admin">Administration du site</h2>

        <?php if (isset($_SESSION['updateSite'])) : ?>
            <?php if ($_SESSION['updateSite'] == "AjtConcert") : ?>
            <p> Un concert vient d'être ajouté avec succés ! </p>
            <?php elseif ($_SESSION['updateSite'] == "SprConcert") : ?>
            <p> Un concert vient d'être supprimé avec succés ! </p>
            <?php elseif ($_SESSION['updateSite'] == "AjtGroupe") : ?>
            <p> Un groupe vient d'être ajouté avec succés ! </p>
            <?php elseif ($_SESSION['updateSite'] == "SprGroupe") : ?>
            <p> Un groupe vient d'être supprimé avec succés ! </p>
            <?php elseif ($_SESSION['updateSite'] == "modifConcert") : ?>
            <p> Un concert vient d'être modifié avec succés ! </p>
            <?php elseif ($_SESSION['updateSite'] == "modifGroupe") : ?>
            <p> Un groupe vient d'être modifié avec succés ! </p>
            <?php endif; ?>
        <?php endif; ?>







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
                <input type="button" id="modif_concert" name="modif_concert" value="Modifier un concert">
                <input type="button" id="modif_groupe"  name="modif_groupe"  value="Modifier un groupe">
            </div>

            <!-- ============ NOTIFICATIONS ============ -->

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

        <!-- ===============================
             INSERTION DES TABLES DE DONNEES
             =============================== -->

        <div id="table_status">
            <table id="groupes">

                <!-- ============ TABLE GROUPES ============ -->

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

                <!-- ============ TABLE CONCERTS ============ -->

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

                <!-- ============ TABLE USERS ============ -->

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

        <!-- ===============================
             FORMULAIRE MODIFICATION D'UN CONCERT
             =============================== -->

        <form action="admin.php?action=modifCrt" id="modifConcert" class="formulaire" method="post">
            <fieldset id="form-ajout">
                <legend>Modification d'un concert</legend>
                <p>
                    <label for="nom-groupe"> Nom du groupe : </label>
                    <input type="text" name="nomGroupe" required>
                </p>
                <p>
                    <label for="lieu"> Lieu : </label>
                    <input type="text" name="lieu" required>
                </p>
                <p>
                    <label for="date"> Date : </label>
                    <input type="date" name="date" required>
                </p>
                <?php if (isset($_GET['action']) && $_GET['action'] == "modifCrt") : ?>
                <p>
                    <label for="date"> Prix de la place : </label>
                    <input type="text" name="prix" required>
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
                <legend>Modification d'un groupe</legend>
                <p>
                    <label for="nom-groupe"> Nom : </label>
                    <input type="text" name="nomGroupe" required>
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

        <?php require('footer.php'); ?>
    </body>
</html>
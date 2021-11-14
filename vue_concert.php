<?php

session_start();

if(isset($_SESSION['login']) && isset($_SESSION['pass'])) {
    $login = $_SESSION['login'];
    $pass = $_SESSION['pass'];
}

if(isset($_GET['nom'])) {
    $nomRecup = htmlspecialchars($_GET['nom']);
}

// Inclusion du fichier de connexion
include('connexion.php');
// Appel de méthode de connexion
$connexion = connexionBd();

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
        <title>TrouvesTonConcert</title>
    </head>
    <body>
        <?php require('header.php');?>

        <?php if (isset($login)) : ?>
            <?php if ($login == 'admin' && $pass == 'admin') : ?>
                <p id="info-connection"> Vous êtes connecté en tant qu'administrateur </p>
            <?php else : ?>
                <p id="info-connection"> Vous êtes connecté en tant que : <?= $login; ?> </p>
            <?php endif; ?>
        <?php else : ?>
            <p id="info-connection"> Vous n'êtes pas connecté </p>
        <?php endif; ?>

        <!-- ===============================
             FORMULAIRE DE CONNEXION
             =============================== -->

        <form id="formulaire" method="post" action="login.php">
            <fieldset id="form-id-admin">
                <legend>Identification administrateur</legend>
                <p>
                    <label for="identifiant">Identifiant: </label>
                    <input type="text" placeholder="identifiant" name="login" required>
                </p>
                <p>
                    <label for="motDePasse">Mot de passe:</label>
                    <input type="password" placeholder="Mot de passe" name="pass" required>
                </p>
                <p>
                    <a href="ajoutUser.php" class="inscription"> Je m'inscrit </a>
                </p>
            </fieldset>
            <p class="submit">
                <input type="submit" id="btnSubmit" value="Continuer" name="send"/>
                <input type="reset" id="btnReset" value="Annuler" />
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
                            <?php break; ?>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>

        <p class="retourIndex">
            <a href="index.php"> Retour </a>
        </p>

        <?php require('footer.php');?>
    </body>
</html>

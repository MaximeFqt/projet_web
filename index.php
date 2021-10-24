<?php

// Inclusion du fichier
include('connexion.php');
// Appel de la méthode permettant la connexion à la BDD
$connexion = connexionBd();

$sql = "select * 
        from concerts C
        join groupe G on G.id_groupe = C.groupe;
        ";

$concerts = $connexion->query($sql);
$concert = $concerts->fetchAll(PDO::FETCH_OBJ);

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
        <title>TrouvesTonConcert</title>
    </head>

    <body>
        <?php require("header.php");?>

        <h2> Réservez votre place pour voir vos artistes <br> préférés ! </h2>

        <ul id="list_group">
            <?php foreach ($concert as $unGroupe): ?>
                <li class="group">
                    <img src="<?=$unGroupe->image;?>" alt="<?= $unGroupe->nom; ?>">
                    <p> Nom : <?= $unGroupe->nom; ?> </p>
                    <p> Lieu : <?= $unGroupe->lieu; ?> </p>
                    <p> Prix : <?= $unGroupe->prix_place; ?> </p>
                    <a href="vue_concert.php?nom=<?=$unGroupe->nom;?>" class="lien-details"> Voir les détails</a>
                </li>
            <?php endforeach; ?>
        </ul>

        <?php require("footer.php");?>
    </body>
</html>

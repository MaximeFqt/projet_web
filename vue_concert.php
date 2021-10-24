<?php

if(isset($_GET['nom'])) {
    $nomRecup = htmlspecialchars($_GET['nom']);
}

// Inclusion du fichier de connexion
include('connexion.php');
// Appel de méthode de connexion
$connexion = connexionBd();

// Requete recuperation infos sur les groupes
$recupImage = "select * 
               from concerts C
               join groupe G on G.id_groupe = C.groupe;
               ";

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
        <title>TrouvesTonConcert</title>
    </head>
    <body>
        <?php require('header.php');?>

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

        <?php require('footer.php');?>
    </body>
</html>

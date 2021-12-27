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

if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
    $id = htmlspecialchars($_SESSION['id']);

    $sql = "select * from reservations R join groupes Gr on Gr.id_groupe = R.groupe where R.idUser = '$id';";
    $reservations = $connexion->query($sql);

    if ($reservations->rowCount() > 0) {
        // Traitement de la requête
        $reserv = $reservations->fetchAll(PDO::FETCH_OBJ);

        $_SESSION['panier'] = "unfree";

    } else {
        $_SESSION['panier'] = "empty";
    }

    if (isset($_POST['annulReserv']) && isset($_POST['idRes']) && !empty($_POST['idRes'])) {

        $idRes = htmlspecialchars($_POST['idRes']);

        $sql = "select * from reservations where id_res ='$idRes';";
        $reserv = $connexion->query($sql);

        if ($reserv->rowCount() === 1) {

            $res = $reserv->fetchAll(PDO::FETCH_OBJ);

            $deleteRes = "delete from reservations where id_res = '$idRes';";
            $deleteRes = $connexion->exec($deleteRes);

            header('location: panier.php');

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
        <script src="js/comportement.js"></script>
        <title> Concertôt </title>
    </head>
    <body>

        <?php include('utils/header.php'); ?>

        <!-- ===============================
                 INFORMATIONS DU PANIER
             =============================== -->

        <?php if (!isset($_SESSION['login'])) : ?>
            <h2 id="titre"> Connectez-vous pour avoir accès à votre panier </h2>
        <?php elseif (isset($_SESSION['panier']) && $_SESSION['panier'] == "empty") : ?>
            <h2 id="titre"> Votre panier est vide ! </h2>
        <?php elseif (isset($_SESSION['panier']) && $_SESSION['panier'] == "unfree") : ?>
        <h2 id="titre"> Voici votre panier </h2>
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


        <!--
        Pouvoir indiquer si le panier est vide et pouvoir ajouter des concerts
        -->

        <div id="table_status">
            <?php if (isset($_SESSION['panier']) && $_SESSION['panier'] == "unfree") : ?>
                <table id="table_panier">
                    <tr>
                        <th> Nom du groupe </th>
                        <th> Nombre de place </th>
                        <th> Lieu </th>
                        <th> Date </th>
                        <th> Prix </th>
                        <th>  </th>
                    </tr>

                    <?php foreach ($reserv as $uneReserv) : ?>

                        <tr>
                            <td><?= $uneReserv->nom ?></td>
                            <td><?= $uneReserv->nbPlace ?></td>
                            <td><?= $uneReserv->lieu ?> </td>
                            <td><?= $uneReserv->date ?> </td>
                            <td><?= $uneReserv->prixTotal ?> </td>
                            <td id="btnAnnulReserv">
                                <form action="panier.php" method="post">
                                    <input type="hidden" name="idRes" value="<?= $uneReserv->id_res ?>">
                                    <input type="submit" name="annulReserv" value="X">
                                </form>
                            </td>
                        </tr>

                    <?php endforeach; ?>

                </table>
            <?php endif; ?>
        </div>

        <?php include('utils/footer.php'); ?>

    </body>
</html>

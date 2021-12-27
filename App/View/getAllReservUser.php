<?php

//var_dump($content);

?>

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
            <a href="viewAjoutUser.php" class="inscription"> Je m'inscrit </a>
        </p>
    </fieldset>
    <p class="submit">
        <input type="submit" id="btnSubmitLogin" value="Continuer" name="send"/>
        <input type="reset" id="btnResetLogin" value="Annuler" />
    </p>
</form>


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

            <?php foreach ($content as $uneReserv) : ?>

                <tr>
                    <td><?= $uneReserv['nom'] ?></td>
                    <td><?= $uneReserv['nbPlace'] ?></td>
                    <td><?= $uneReserv['lieu'] ?> </td>
                    <td><?= $uneReserv['date'] ?> </td>
                    <td><?= $uneReserv['prixTotal'] ?> </td>
                    <td id="btnAnnulReserv">
                        <form action="../../index.php?panier=true" method="post">
                            <input type="hidden" name="idRes" value="<?= $uneReserv['idRes'] ?>">
                            <input type="submit" name="annulReserv" value="X">
                        </form>
                    </td>
                </tr>

            <?php endforeach; ?>

        </table>
    <?php endif; ?>
</div>


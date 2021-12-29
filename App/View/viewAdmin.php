<?php

?>

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
     FORMULAIRE D'AJOUT D'UN CONCERT
     =============================== -->

<form action="../../index.php?admin=true" id="ajoutConcert" class="formulaire" method="post">
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
     FORMULAIRE D'AJOUT D'UN GROUPE
     =============================== -->

<form action="../../index.php?admin=true" id="ajoutGroupe" class="formulaire" method="post" enctype="multipart/form-data">
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
     FORMULAIRE AJOUT D'UN GENRE
     =============================== -->

<form action="../../index.php?admin=true" id="ajoutGenre" class="formulaire" method="post">
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
     FORMULAIRE SUPPRESSION D'UN CONCERT
     =============================== -->

<form action="../../index.php?admin=true" id="supprConcert" class="formulaire" method="post">
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
     FORMULAIRE SUPPRESSION D'UN GROUPE
     =============================== -->

<form action="../../index.php?admin=true" id="supprGroupe" class="formulaire" method="post">
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
     FORMULAIRE SUPPRESSION D'UN GENRE
     =============================== -->

<form action="../../index.php?admin=true" id="supprGenre" class="formulaire" method="post">
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
     FORMULAIRE MODIFICATION D'UN CONCERT
     =============================== -->

<form  action="../../index.php?admin=true&modifConcert=true" id="modifConcert" class="formulaire" method="post">
    <fieldset id="form-ajout">
        <?php if (isset($_GET['modifConcert']) && !empty($_GET['modifConcert']) && $_GET['modifConcert'] == "true") : ?>
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
        <?php if (isset($_GET['modifConcert']) && $_GET['modifConcert'] == "true") : ?>
            <p>
                <label for="prix"> Nouveau prix: </label>
                <input type="text" name="prix" id="prix" required>
            </p>
        <?php endif; ?>
    </fieldset>

    <p class="submit">
        <input type="submit" id="btnSubmit" value="Continuer"
            <?php if (isset($_GET['modifConcert']) && $_GET['modifConcert'] == "true") : ?>
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

<form action="../../index.php?admin=true&modifGroupe=true" id="modifGroupe" class="formulaire" method="post" enctype="multipart/form-data">
    <fieldset id="form-ajout">
        <?php if (isset($_GET['modifGroupe']) && !empty($_GET['modifGroupe']) && $_GET['modifGroupe'] == "true") : ?>
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
        <?php if (isset($_GET['modifGroupe']) && $_GET['modifGroupe'] == "true") : ?>
            <p>
                <label for="image"> Image du groupe : </label>
                <input type="file" name="image" accept="image/jpeg" required>
            </p>
        <?php endif; ?>
    </fieldset>

    <p class="submit">
        <input type="submit" id="btnSubmit" value="Continuer"
            <?php if (isset($_GET['modifGroupe']) && $_GET['modifGroupe'] == "true") : ?>
                name="modificationGrp"
            <?php else : ?>
                name="sendMdfGrp"
            <?php endif; ?>
        />
        <input type="reset" id="btnReset" value="Annuler"/>
    </p>
</form>

<!-- ===============================
     FORMULAIRE MODIFICATION D'UN GENRE
     =============================== -->

<form action="../../index.php?admin=true&modifGenre=true" id="modifGenre" class="formulaire" method="post">
    <fieldset id="form-ajout">
        <?php if (isset($_GET['modifGenre']) && !empty($_GET['modifGenre']) && $_GET['modifGenre'] == "true") : ?>
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
            <?php if (isset($_GET['modifGenre']) && $_GET['modifGenre'] == "true") : ?>
                name="modificationGenre"
            <?php else : ?>
                name="sendMdfGenre"
            <?php endif; ?>
        />
        <input type="reset" id="btnReset" value="Annuler"/>
    </p>
</form>

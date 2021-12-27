<?php

?>

<h1> Vous n'êtes pas enregistré parmis les utilisaterus de notre site </h1>
<h2> Souhaitez-vous vous enregistrer ? </h2>

<!-- ===============================
     FORMULAIRE D'INSCRIPION AU SITE
     =============================== -->

<form id="formulaire-enregistrement" method="post" action="../../index.php">
    <fieldset>
        <legend> Enregistrement des informations</legend>
        <p>
            <label for="id_new_user"> * Identifiant : </label>
            <input type="text" placeholder="Identifiant" id="id_new_user" name="login" autocomplete="off" required/>
        </p>
        <p>
            <label for="email_new_user"> * Email : </label>
            <input type="email" placeholder="ex@emple.fr" id="email_new_user" name="email" autocomplete="off"/>
        </p>
        <p>
            <label for="pass_new_user"> * Mot de passe : </label>
            <input type="password" placeholder="Mot de passe" id="pass_new_user" name="pass" required>
        </p>
        <p>
            <label for="pass_confirm_new_user"> * Confirmation : </label>
            <input type="password" placeholder="Confirmation" id="pass_confirm_new_user" required>
        </p>
        <p> * Champs obligatoires</p>
        <p id="infoFormulaireUser"></p>
    </fieldset>
    <p class="submit">
        <input type="button" id="btnSubmit_ajout" value="Continuer" name="sendAjoutUser"/>
        <input type="reset" id="btnReset_ajout" value="Annuler"/>
    </p>
    <p class="retourIndex">
        <a href="../../index.php"> Retour </a>
    </p>
</form>

/* FICHER GERANT LE FORMULAIRE D'INSCRIPTION AU SITE */

document.addEventListener('DOMContentLoaded', principale);

function principale() {

    // FORMULAIRE DE VERIFICATION POUR L'ENREGISTREMENT DES UTILISATEURS

    // Bouton continuer
    let btnVerif = document.getElementById('btnSubmit_ajout');
    btnVerif.addEventListener('click', verif);

    function verif() {
        let login = document.getElementById('id_new_user');
        let pass = document.getElementById('pass_new_user');
        let email = document.getElementById('email_new_user');
        let confirmPass = document.getElementById('pass_confirm_new_user');
        let msg = document.getElementById('infoFormulaireUser');

        let MESSAGE_DERREUR = "Veuillez remplir les champs vides";
        let MESSAGE_ERREUR_CONFIRM = "Les mots des passe ne correspondent pas";
        let MESSAGE_INCORRECT = "'Admin' n'est pas autorisé en login ou mot de passe";

        // Si aucun champs n'est vide
        if (!(login.value === "") && !(pass.value === "") && !(confirmPass.value === "") && !(email.value === "")) {
            msg.style.display = 'none';

            // Si le login ou le mot de passe == admin
            if (login.value === 'admin' || pass.value === 'admin') {
                msg.style.display = 'block';
                msg.innerHTML = MESSAGE_INCORRECT;

            } else {
                // Si les mots de passe correspondent
                if (pass.value === confirmPass.value) {
                    pass.style.border = 'solid 3px darkgreen';
                    confirmPass.style.border = 'solid 3px darkgreen';
                    // Changement du type de bouton
                    btnVerif.setAttribute('type', 'submit');
                } else {
                    pass.style.border = 'solid 3px darkred';
                    confirmPass.style.border = 'solid 3px darkred';
                    // Affichage du message d'erreur
                    msg.style.display = 'block';
                    msg.innerHTML = MESSAGE_ERREUR_CONFIRM;
                }
            }
        } else {
            // Affichage du message d'erreur
            msg.style.display = 'block';
            msg.innerHTML = MESSAGE_DERREUR;
        }
    }

    // Bouton annuler
    let btnAnnuler = document.getElementById('btnReset_ajout');
    btnAnnuler.addEventListener('click', annuler);

    // Modification d'affichage si bouton annuler
    function annuler() {
        let pass = document.getElementById('pass_new_user');
        let confirmPass = document.getElementById('pass_confirm_new_user');
        let msg = document.getElementById('infoFormulaireUser');

        pass.style.border = 'none';
        confirmPass.style.border = 'none';
        msg.style.display = 'none';

    }
}
/* FICHIER GLOBAL */

document.addEventListener('DOMContentLoaded', principale);

function principale() {
    console.log('Démarrage de la fonction principale !')

    // APPARITION DU FORMULAIRE DE LOGIN
    let btnLogin = document.getElementById('login'); // Récupération du bouton
    btnLogin.addEventListener('click', openLoginForm);       // Ajout de l'évent

    function openLoginForm() {
        console.log("Apparition du formulaire d'identification administrateur");

        // Récupération du formulaire
        let form = document.getElementById('formulaire');
        form.style.display = 'block';
        form.style.zIndex = '3';

        let closeForm = document.getElementById('btnResetLogin');
        closeForm.addEventListener('click', close);

        function close() {
            form.style.display = 'none';
        }
    }

}

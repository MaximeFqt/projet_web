/* FICHIER GLOBAL */

document.addEventListener('DOMContentLoaded', principale);

function principale() {
    console.log('Démarrage de la fonction principale !')

    // APPARITION DU FORMULAIRE DE LOGIN
    let btnLogin = document.getElementById('login');
    btnLogin.addEventListener('click', loginForm);

    function loginForm() {
        console.log("Apparition du formulaire d'identification administrateur");

        let form = document.getElementById('formulaire');
        form.style.display = 'block';
        form.style.zIndex = '3';

        let closeForm = document.getElementById('btnReset');
        closeForm.addEventListener('click', close);

        function close() {
            form.style.display = 'none';
            form.style.zIndex = '0';
        }
    }

}

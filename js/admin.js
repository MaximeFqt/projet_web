/* FICHER GERANT LA PARTIE ADMINISTRATION DU SITE */

document.addEventListener('DOMContentLoaded', principale);

function principale() {
    console.log('Démarrage de la fonctione principale');

    // Récupération des boutons d'ations
    let btnAjtConcert = document.getElementById('ajout_concert');
    let btnSprConcert = document.getElementById('suppr_concert');
    let btnAjtGroupe  = document.getElementById('ajout_groupe');
    let btnSprGroupe  = document.getElementById('suppr_groupe');
    let btnMdfConcert = document.getElementById('modif_concert');
    let btnMdfGroupe  = document.getElementById('modif_groupe');
    let btnAjtGenre   = document.getElementById('ajout_genre');
    let btnSprGenre   = document.getElementById('suppr_genre');
    let btnMdfGenre   = document.getElementById('modif_genre');

    // Récupération des tables de données
    let tablesDonnees = document.getElementById('table_status');

    // Récupération du bouton annuler
    let btnAnnul = document.querySelectorAll('#btnReset');
    // Ajout de l'événement à tous les éléments
    btnAnnul.forEach(
        btn => {
            btn.addEventListener('click', annuler);
        }
    )

    // Récupération des formulaires
    let formAjtConcert = document.getElementById('ajoutConcert');
    let formSprConcert = document.getElementById('supprConcert');
    let formAjtGroupe  = document.getElementById('ajoutGroupe');
    let formSprGroupe  = document.getElementById('supprGroupe');
    let formAjtGenre   = document.getElementById('ajoutGenre');
    let formSprGenre   = document.getElementById('supprGenre');


    // GESTION DE L'URL
    let currentUrl = document.location.href;

    // Supprimons l'éventuel dernier slash de l'URL
    currentUrl = currentUrl.replace(/\/$/, "");
    // Gardons dans la variable queue_url uniquement la portion derrière le dernier slash de currentUrl
    let endUrl = currentUrl.substring (currentUrl.lastIndexOf( "/" )+1 );


    let formMdfConcert = document.getElementById('modifConcert');
    let formMdfGroupe  = document.getElementById('modifGroupe');
    let formMdfGenre   = document.getElementById('modifGenre');

    // Ajout des événements
    btnAjtConcert.addEventListener('click', ajoutConcert);
    btnAjtGroupe .addEventListener('click', ajoutGroupe );
    btnAjtGenre  .addEventListener('click', ajoutGenre  );

    btnSprConcert.addEventListener('click', supprConcert);
    btnSprGroupe .addEventListener('click', supprGroupe );
    btnSprGenre  .addEventListener('click', supprGenre  );

    btnMdfConcert.addEventListener('click', modifConcert);
    btnMdfGroupe .addEventListener('click', modifGroupe );
    btnMdfGenre  .addEventListener('click', modifGenre  );

    // Lancement des événements formulaire
    if (endUrl === "index.php?admin=true&modifConcert=true") {
        modifConcert();
    } else if (endUrl === "index.php?admin=true&modifGroupe=true") {
        modifGroupe();
    } else if (endUrl === "index.php?admin=true&modifGenre=true") {
        modifGenre();
    }

                                                    /*----------
                                                      FONCTIONS
                                                    ----------*/

    // AJOUT D'UN CONCERT
    function ajoutConcert() {

        console.log('Ajout d\'un concert ! ');
        formAjtConcert.style.display = 'block';

        // Traitement des formulaires
        formSprConcert.style.display = 'none';
        formAjtGroupe.style.display  = 'none';
        formSprGroupe.style.display  = 'none';
        formMdfConcert.style.display = 'none';
        formMdfGroupe.style.display  = 'none';
        formAjtGenre.style.display   = 'none';
        formSprGenre.style.display   = 'none';
        formMdfGenre.style.display   = 'none';

        // Traitement des boutons
        document.getElementById('action_admin').style.display = 'none';
        tablesDonnees.style.display = 'none';

    }

    // SUPPRESSION D'UN CONCERT
    function supprConcert() {

        console.log('Suppression d\'un concert ! ');
        formSprConcert.style.display = 'block';

        // Traitement des formulaires
        formAjtConcert.style.display = 'none';
        formAjtGroupe.style.display  = 'none';
        formSprGroupe.style.display  = 'none';
        formMdfConcert.style.display = 'none';
        formMdfGroupe.style.display  = 'none';
        formAjtGenre.style.display   = 'none';
        formSprGenre.style.display   = 'none';
        formMdfGenre.style.display   = 'none';


        // Traitement des boutons
        document.getElementById('action_admin').style.display = 'none';
        tablesDonnees.style.display = 'none';

    }

    // AJOUT D'UN GROUPE
    function ajoutGroupe() {

        console.log('Ajout d\'un groupe ! ');
        formAjtGroupe.style.display = 'block';

        // Traitement des formulaires
        formAjtConcert.style.display = 'none';
        formSprConcert.style.display = 'none';
        formSprGroupe.style.display  = 'none';
        formMdfConcert.style.display = 'none';
        formMdfGroupe.style.display  = 'none';
        formAjtGenre.style.display   = 'none';
        formSprGenre.style.display   = 'none';
        formMdfGenre.style.display   = 'none';

        // Traitement des boutons
        document.getElementById('action_admin').style.display = 'none';
        tablesDonnees.style.display = 'none';

    }

    // SUPPRESSION D'UN GROUPE
    function supprGroupe() {

        console.log('Suppression d\'un groupe ! ');
        formSprGroupe.style.display = 'block';

        // Traitement des formulaires
        formAjtConcert.style.display = 'none';
        formSprConcert.style.display = 'none';
        formAjtGroupe.style.display  = 'none';
        formMdfConcert.style.display = 'none';
        formMdfGroupe.style.display  = 'none';
        formAjtGenre.style.display   = 'none';
        formSprGenre.style.display   = 'none';
        formMdfGenre.style.display   = 'none';

        // Traitement des boutons
        document.getElementById('action_admin').style.display = 'none';
        tablesDonnees.style.display = 'none';

    }

    // MODIFICATION D'UN CONCERT
    function modifConcert() {

        console.log('Modification d\'un concert ! ');
        formMdfConcert.style.display = 'block';

        // Traitement des formulaires
        formAjtConcert.style.display = 'none';
        formSprConcert.style.display = 'none';
        formAjtGroupe.style.display  = 'none';
        formSprGroupe.style.display  = 'none';
        formMdfGroupe.style.display  = 'none';
        formAjtGenre.style.display   = 'none';
        formSprGenre.style.display   = 'none';
        formMdfGenre.style.display   = 'none';

        // Traitement des boutons
        document.getElementById('action_admin').style.display = 'none';
        tablesDonnees.style.display = 'none';

    }

    // MODIFICATION D'UN GROUPE
    function modifGroupe() {

        console.log('Modification d\'un groupe ! ');
        formMdfGroupe.style.display = 'block';

        // Traitement des formulaires
        formAjtConcert.style.display = 'none';
        formSprConcert.style.display = 'none';
        formAjtGroupe.style.display  = 'none';
        formSprGroupe.style.display  = 'none';
        formMdfConcert.style.display = 'none';
        formAjtGenre.style.display   = 'none';
        formSprGenre.style.display   = 'none';
        formMdfGenre.style.display   = 'none';

        // Traitement des boutons
        document.getElementById('action_admin').style.display = 'none';
        tablesDonnees.style.display = 'none';

    }

    // AJOUT D'UN GENRE
    function ajoutGenre() {

        console.log('Ajout d\'un genre ! ');
        formAjtGenre.style.display = 'block';

        // Traitement des formulaires
        formAjtConcert.style.display = 'none';
        formSprConcert.style.display = 'none';
        formMdfConcert.style.display = 'none';
        formAjtGroupe.style.display  = 'none';
        formSprGroupe.style.display  = 'none';
        formMdfConcert.style.display = 'none';
        formSprGenre.style.display   = 'none';
        formMdfGenre.style.display   = 'none';

        // Traitement des boutons
        document.getElementById('action_admin').style.display = 'none';
        tablesDonnees.style.display = 'none';

    }

    // SUPPRESSION D'UN GENRE
    function supprGenre() {

        console.log('Suppression d\'un genre ! ');
        formSprGenre.style.display = 'block';

        // Traitement des formulaires
        formAjtConcert.style.display = 'none';
        formSprConcert.style.display = 'none';
        formMdfConcert.style.display = 'none';
        formAjtGroupe.style.display  = 'none';
        formSprGroupe.style.display  = 'none';
        formMdfConcert.style.display = 'none';
        formAjtGenre.style.display   = 'none';
        formMdfGenre.style.display   = 'none';

        // Traitement des boutons
        document.getElementById('action_admin').style.display = 'none';
        tablesDonnees.style.display = 'none';

    }

    // MODIFICATION D'UN GENRE
    function modifGenre() {

        console.log('Modification d\'un genre ! ');
        formMdfGenre.style.display = 'block';

        // Traitement des formulaires
        formAjtConcert.style.display = 'none';
        formSprConcert.style.display = 'none';
        formMdfConcert.style.display = 'none';
        formAjtGroupe.style.display  = 'none';
        formSprGroupe.style.display  = 'none';
        formMdfConcert.style.display = 'none';
        formAjtGenre.style.display   = 'none';
        formSprGenre.style.display   = 'none';

        // Traitement des boutons
        document.getElementById('action_admin').style.display = 'none';
        tablesDonnees.style.display = 'none';

    }

    // FONCTION DU BOUTON ANNULER DANS LES FORMULAIRES
    function annuler() {

        endUrl = 'index.php?admin=true';
        document.location.href = endUrl ;

        // Traitement des boutons
        document.getElementById('action_admin').style.display = 'block';
        tablesDonnees.style.display = 'block';

        formAjtConcert.style.display = 'none';
        formSprConcert.style.display = 'none';
        formAjtGroupe.style.display  = 'none';
        formSprGroupe.style.display  = 'none';
        formMdfConcert.style.display = 'none';
        formMdfGroupe.style.display  = 'none';
        formAjtGenre.style.display   = 'none';
        formSprGenre.style.display   = 'none';
        formMdfGenre.style.display   = 'none';

    }



}
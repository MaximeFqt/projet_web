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
    let formMdfConcert = document.getElementById('modifConcert');
    let formMdfGroupe  = document.getElementById('modifGroupe');

    // Ajout des événements
    btnAjtConcert.addEventListener('click', ajoutConcert);
    btnSprConcert.addEventListener('click', supprConcert);
    btnAjtGroupe .addEventListener('click', ajoutGroupe );
    btnSprGroupe .addEventListener('click', supprGroupe );
    btnMdfConcert.addEventListener('click', modifConcert);
    btnMdfGroupe .addEventListener('click', modifGroupe );

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

        // Traitement des boutons
        document.getElementById('action_admin').style.display = 'none';
        tablesDonnees.style.display = 'none';

        btnAnnul.addEventListener('click', annuler);

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

        // Traitement des boutons
        document.getElementById('action_admin').style.display = 'none';
        tablesDonnees.style.display = 'none';

        btnAnnul.addEventListener('click', annuler);

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

        // Traitement des boutons
        document.getElementById('action_admin').style.display = 'none';
        tablesDonnees.style.display = 'none';

        btnAnnul.addEventListener('click', annuler);

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

        // Traitement des boutons
        document.getElementById('action_admin').style.display = 'none';
        tablesDonnees.style.display = 'none';

        btnAnnul.addEventListener('click', annuler);

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

        // Traitement des boutons
        document.getElementById('action_admin').style.display = 'none';
        tablesDonnees.style.display = 'none';

        btnAnnul.addEventListener('click', annuler);

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

        // Traitement des boutons
        document.getElementById('action_admin').style.display = 'none';
        tablesDonnees.style.display = 'none';

        btnAnnul.addEventListener('click', annuler);

    }

    // FONCTION DU BOUTON ANNULER DANS LES FORMULAIRES
    function annuler() {
        // Traitement des boutons
        document.getElementById('action_admin').style.display = 'block';
        tablesDonnees.style.display = 'block';

        formAjtConcert.style.display ='none';
        formSprConcert.style.display ='none';
        formAjtGroupe.style.display  ='none';
        formSprGroupe.style.display  ='none';
        formMdfConcert.style.display ='none';
        formMdfGroupe.style.display  ='none';

    }



}
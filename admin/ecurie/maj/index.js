"use strict";

import {
    configurerFormulaire,
    donneesValides,
    filtrerLaSaisie,
    confirmer,
    afficherErreurSaisie,
    afficherSucces,
    afficherErreur,
    retournerVersApresConfirmation
} from '/composant/fonction.js';

/* global lesPays, lesEcuries*/

// objet global contenant les informations sur la catégorie sélectionnée
let element = lesEcuries[0];

// récupération des éléments de l'interface
let id = document.getElementById('id');
let nom = document.getElementById('nom');
let idPays = document.getElementById('idPays');
let btnModifier = document.getElementById('btnModifier');
let btnSupprimer = document.getElementById('btnSupprimer');

// initialisation des données de l'interface

// alimentation de la zone de liste des grands prix
for (const element of lesEcuries) {
    id.add(new Option(element.nom, element.id));
}

// alimentation de la zone de liste des pays
for (const element of lesPays) {
    idPays.add(new Option(element.nom, element.id));
}

// afficher l'écurie actuellement sélectionnée
afficher(0);

// Déclaration des gestionnaires d'événements

configurerFormulaire(true);
filtrerLaSaisie('nom', /[A-Za-zÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ '-]/);


// sur le changement de Grand Prix, il faut afficher les données du grand prix sélectionné
id.onchange = () => {
    afficher(id.selectedIndex);
};

// demande de modification
btnModifier.onclick = () => {
    if (donneesValides()) {
        modifier();
    }
};

// demande de suppression
btnSupprimer.onclick = function () {
    confirmer(supprimer);
};


// afficher l'écurie sélectionnée dans la liste
function afficher(index) {
    element = lesEcuries[index];
    nom.value = element.nom;
    idPays.value = element.idPays;

    btnSupprimer.style.display = parseInt(element.deleteOk) === 1 ? 'block' : 'none';
}

function modifier() {
    // transmission des paramètres
    const lesValeurs = {};
    if (nom.value !== element.nom) {
        lesValeurs.nom = nom.value;
    }

    if (idPays.value !== element.idPays) {
        lesValeurs.idPays = idPays.value;
    }
    $.ajax({
        url: '/admin/ajax/modifier.php',
        method: 'POST',
        async : false,
        data: {
            table : 'ecurie',
            id: element.id,
            lesValeurs : JSON.stringify(lesValeurs)
        },
        dataType: "json",
        success: (data) => {
            if (data.success) {
                afficherSucces("Modification enregistrée");
                // report des modifications dans le tableau lesEcuries
                lesEcuries[id.selectedIndex].nom = nom.value;
                lesEcuries[id.selectedIndex].idPays = idPays.value;

                // mise à jour de la zone de liste
                id.options[id.selectedIndex].text = nom.value;
            } else {
                for (const key in data.error) {
                    const message = data.error[key];
                    if (key === 'system') {
                        console.log(message);
                        afficherErreur('Une erreur est survenue lors de l\'ajout');
                    } else if (key === 'global') {
                        afficherErreur(message);
                    } else {
                        afficherErreurSaisie(key, message);
                    }
                }
            }
        },
        error: reponse => {
            afficherErreur('Une erreur imprévue est survenue');
            console.log(reponse.responseText);
        }
    });
}

function supprimer() {
    $.ajax({
        url: '/admin/ajax/supprimer.php',
        type: 'POST',
        async: false,
        data: {
            table : 'ecurie',
            id: id.value
        },
        dataType: "json",
        success: (data) => {
            if (data.success) {
                // suppression de l'écurie dans le tableau lesEcuries
                lesEcuries.splice(id.selectedIndex, 1);
                let nb = lesEcuries.length;
                let index = id.selectedIndex;
                // si on vient de supprimer le dernier enregistrement, il faut quitter la page :
                if (nb === 0) {
                    retournerVersApresConfirmation("Il n'y a plus d'écurie dans la base.", '/admin' );
                } else if (nb === id.selectedIndex) {
                    index--;
                }
                // suppression dans la zone de liste selectedIndex repasse automatiquement à 0
                id.removeChild(id[id.selectedIndex]);
                // sélection du prochain enregistrement
                id.selectedIndex = index;
                // affichage des données de l'écurie sélectionnée
                afficher(index);
            } else {
                for (const key in data.error) {
                    const message = data.error[key];
                    if (key === 'system') {
                        console.error(message);
                        afficherErreur('Une erreur est survenue lors de la suppression');
                    } else if (key === 'global') {
                        afficherErreur(message);
                    } else { // ne doit jamais arriver
                        afficherErreur(message);
                    }
                }
            }
        },
        error: reponse => {
            afficherErreur('Une erreur imprévue est survenue');
            console.log(reponse.responseText);
        }
    });
}


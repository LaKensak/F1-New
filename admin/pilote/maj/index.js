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

/* global lesPays, lesPilotes, lesEcuries */

// objet global contenant les informations sur la catégorie sélectionnée
let element = lesPilotes[0];

// récupération des éléments de l'interface
let id = document.getElementById('id');
let numero = document.getElementById('numero');
let nom = document.getElementById('nom');
let prenom = document.getElementById('prenom');
let idPays = document.getElementById('idPays');
let idEcurie = document.getElementById('idEcurie');
let numPilote = document.getElementById('numPilote');
let btnModifier = document.getElementById('btnModifier');
let btnSupprimer = document.getElementById('btnSupprimer');

// alimentation de la zone de liste des grands prix
for (let element of lesPilotes) {
    id.add(new Option(element.nom + ' ' + element.prenom, element.id));
}

for (let element of lesEcuries) {
    idEcurie.add(new Option(element.nom, element.id));
}

// alimentation de la zone de liste des pays
for (let element of lesPays) {
    idPays.add(new Option(element.nom, element.id));
}

// charger le grand prix actuellement sélectionné
afficher(0);

// Déclaration des gestionnaires d'événements

configurerFormulaire(true);
filtrerLaSaisie('nom', /[A-Za-zÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ '-]/);
filtrerLaSaisie('prenom', /[A-Za-zÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ '-]/);

// sur le changement d'un pilote, il faut afficher les données du Pilote sélectionné
id.onchange = () => {
    afficher(id.selectedIndex);
};

// demande de modification d'un Pilote
btnModifier.onclick = () => {
    if (donneesValides()) {
        modifier();
    }
};

// demande de suppression du résultat
btnSupprimer.onclick = function () {
    confirmer(supprimer);
};

// recupère le classement du grand prix sélectionné dans la liste
function afficher(index) {
    element = lesPilotes[index];
    numero.value = element.id;
    nom.value = element.nom;
    prenom.value = element.prenom;
    idEcurie.value = element.idEcurie;
    idPays.value = element.idPays;
    numPilote.value = element.numPilote;
    btnSupprimer.style.display = parseInt(element.deleteOk) === 1 ? 'none' : 'block';
}

function modifier() {
    const lesValeurs = {};

    if (nom.value !== element.nom) {
        lesValeurs.nom = nom.value;
    }

    if (prenom.value !== element.prenom) {
        lesValeurs.prenom = prenom.value;
    }

    if (idEcurie.value !== element.idEcurie) {
        lesValeurs.idEcurie = idEcurie.value;
    }

    if (numPilote.value !== element.numPilote) {
        lesValeurs.numPilote = numPilote.value;
    }

    if (idPays.value !== element.idPays) {
        lesValeurs.idPays = idPays.value;
    }

    let newId = numero.value;
    if (newId !== element.id) {
        lesValeurs.newId = newId;
    }

    $.ajax({
        url: '/admin/ajax/modifier.php',
        method: 'POST',
        async: false,
        data: {
            table: 'pilote',
            id: element.id,
            lesValeurs: JSON.stringify(lesValeurs)
        },
        dataType: "json",
        success: (data) => {
            if (data.success) {
                afficherSucces("Modification enregistrée");
                // Mettre à jour l'objet local `lesPilotes` et rafraîchir la zone de liste
                lesPilotes[id.selectedIndex].nom = nom.value;
                lesPilotes[id.selectedIndex].prenom = prenom.value;
                lesPilotes[id.selectedIndex].idEcurie = idEcurie.value;
                lesPilotes[id.selectedIndex].numPilote = numPilote.value;
                lesPilotes[id.selectedIndex].idPays = idPays.value;
                if (newId !== element.id) {
                    lesPilotes[id.selectedIndex].id = newId;
                    id.options[id.selectedIndex].value = newId;
                }
                // Mise à jour de la zone de liste
                id.options[id.selectedIndex].text = nom.value + ' ' + prenom.value;
            } else {
                afficherErreur("Erreur lors de la mise à jour");
            }
        },
        error: (reponse) => {
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
            table: 'pilote',
            id: id.value,
        },
        dataType: "json",
        success: (data) => {
            if (data.success) {
                afficherSucces("Suppression enregistrée");
                // suppression d'un pilote dans le tableau lesPilotes
                lesPilotes.splice(id.selectedIndex, 1);
                let nb = lesPilotes.length;
                let index = id.selectedIndex;
                // si on vient de supprimer le dernier enregistrement, il faut quitter la page :
                if (nb === 0) {
                    retournerVersApresConfirmation("Il n'y a plus de pilote dans la base.", '/admin');
                } else if (nb === id.selectedIndex) {
                    index--;
                }
                // suppression dans la zone de liste selectedIndex repasse automatiquement à 0
                id.removeChild(id[id.selectedIndex]);
                // sélection du prochain enregistrement
                id.selectedIndex = index;
                // affichage des données du pilote sélectionné
                afficher(index);
            } else {
                for (const key in data.error) {
                    const message = data.error[key];
                    if (key === 'system') {
                        console.error(message);
                        afficherErreur('Une erreur inattendue est survenue');
                    } else {
                        afficherErreur(message);
                    }
                }
            }
        },
        error: (reponse) => {
            afficherErreur('Une erreur imprévue est survenue');
            console.log(reponse.responseText);
        }
    });
}

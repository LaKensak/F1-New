"use strict";

/* global data */
import {
    confirmer,
    afficherSucces,
    creerTable,
    afficherErreur,
    retournerVersApresConfirmation
} from "/composant/fonction.js";

// récupération des éléments de l'interface
let idGrandPrix = document.getElementById('idGrandPrix');
let resultat = document.getElementById('resultat');
let btnSupprimer = document.getElementById('btnSupprimer');

// initialisation de l'inteface

// alimentation de la zone de liste des grands prix
for (const element of data) {
    idGrandPrix.add(new Option(element.nom, element.id));
}
getClassement();

// gestion des événements

// sur le changement de Grand Prix il faut récupérer le classement
idGrandPrix.onchange = getClassement;

// demande de suppression du résultat
btnSupprimer.onclick = function () {
    confirmer(supprimer);
};

// recupère le classement du grand  prix sélectionné dans la liste
function getClassement() {
    $.ajax({
        url: 'ajax/getclassementgp.php',
        type: 'POST',
        data: {
            idGrandPrix: idGrandPrix.value
        },
        dataType: "json",
        success: afficher,
        error: reponse => {
            afficherErreur('Une erreur imprévue est survenue');
            console.log(reponse.responseText);
        }
    });
}

function afficher(data) {
    resultat.innerHTML = "";
    const option = {
        data: data,
        style: 'margin:auto',

        headStyle: {
            Place: 'text-align: center;',
            Point: 'text-align: center;'
        },
        bodyStyle: {
            Place: 'text-align: center;',
            Point: 'text-align: center;'
        },

    };
    document.getElementById('resultat').appendChild(creerTable(option));
}

function supprimer() {
    $.ajax({
        url: 'ajax/supprimer.php',
        type: 'POST',
        data: {
            table: 'resultat',
            idGrandPrix: idGrandPrix.value
        },
        dataType: "json",
        success: (data) => {
            if (data.success) {
                idGrandPrix.removeChild(idGrandPrix[idGrandPrix.selectedIndex]);
                if (idGrandPrix.length === 0) {
                    let message = "Résultat supprimé, il n'y plus de résultat saisi pour le moment, retour à l'accueil";
                    retournerVersApresConfirmation(message, "/admin");
                } else {
                    afficherSucces("Résultat supprimé");
                    getClassement();
                }
            } else {
                for (const key in data.error) {
                    const message = data.error[key];
                    if (key === 'system') {
                        console.log(message);
                        afficherErreur('Une erreur inattendue est survenue');
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


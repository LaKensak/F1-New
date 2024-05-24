"use strict";
/* global data*/

import {
    donneesValides,
    afficherSucces,
    afficherErreur,
    configurerFormulaire, viderLesChamps, afficherErreurSaisie
} from "/composant/fonction.js";

// récupération des éléments de l'interface
let nom = document.getElementById('nom');
let idPays = document.getElementById('idPays');
let btnAjouter = document.getElementById('btnAjouter');

// configuration du formulaire
configurerFormulaire();

// alimentation des listes déroulantes
for (const element of data) {
    idPays.add(new Option(element.nom, element.id));
}

// données de  test
nom.value = "test";
idPays.value = "nl";

// Les gestionnaires d'événements
btnAjouter.onclick = () => {
    if (donneesValides()) {
        ajouter();
    }
};

// Fonctions
function ajouter() {
    $.ajax({
        url: '/admin/ajax/ajouter.php',
        type: 'POST',
        data: {
            table : 'ecurie',
            nom: nom.value,
            idPays: idPays.value,
        },
        dataType: "json",
        success: (data) => {
            if (data.success) {
                // Mise à jour de l'interface
                viderLesChamps();
                afficherSucces("Opération réalisée avec succès");
            } else {
                for (const key in data.error) {
                    const message = data.error[key];
                    if (key === 'system') {
                        console.log(message);
                        afficherErreur('Une erreur inattendue est survenue');
                    } else if (key === 'global') {
                        afficherErreur(message);
                    } else  {
                        afficherErreurSaisie(key, message );
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







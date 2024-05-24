"use strict";

import {
    configurerFormulaire,
    donneesValides,
    filtrerLaSaisie,
    viderLesChamps,
    afficherErreurSaisie,
    afficherSucces,
    afficherErreur,
} from '/composant/fonction.js';

/* global data, min, max */

// récupération des éléments sur l'interface
let date = document.getElementById('date');
let nom = document.getElementById('nom');
let circuit = document.getElementById('circuit');
let idPays = document.getElementById('idPays');
let btnAjouter = document.getElementById('btnAjouter');

configurerFormulaire(true);
filtrerLaSaisie('nom', /[A-Za-zÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ '-]/);
filtrerLaSaisie('circuit', /[A-Za-zÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ '-]/);
date.min = min;
date.max = max;

// alimentation de la zone de liste
for (const pays of data) {
    idPays.add(new Option(pays.nom, pays.id));
}

// gestionnaire d'événement
btnAjouter.onclick = () => {
    if (donneesValides()) {
        ajouter();
    }
};

nom.focus();

// initialiser
nom.value = 'test';
circuit.value = 'test';
date.value = "2024-03-01";

function ajouter() {
    $.ajax({
        url: '/admin/ajax/ajouter.php',
        method: 'POST',
        data: {
            table : 'grandprix',
            nom: nom.value,
            circuit: circuit.value,
            date:date.value,
            idPays: idPays.value
        },
        dataType: "json",
        success: (data) => {
            if (data.success) {
                // Mise à jour de l'interface
                viderLesChamps();
                afficherSucces("Grand Prix ajouté avec succès");
            } else {
                for (const key in data.error) {
                    const message = data.error[key];
                    if (key === 'system') {
                        console.log(message);
                        afficherErreur('Une erreur innatendue est survenue');
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



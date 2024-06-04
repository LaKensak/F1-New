"use strict";

/* global lesPays, lesEcuries, lesPilotes */

import {
    donneesValides,
    filtrerLaSaisie,
    afficherSucces,
    afficherErreur,
    configurerFormulaire, viderLesChamps, genererMessage, afficherErreurSaisie
} from "/composant/fonction.js";

// récupération des éléments de l'interface
let id = document.getElementById('id');
let nom = document.getElementById('nom');
let prenom = document.getElementById('prenom');
let idPays = document.getElementById('idPays');
let idEcurie = document.getElementById('idEcurie');
let numPilote = document.getElementById('numPilote');
let photo = document.getElementById('photo');
let btnAjouter = document.getElementById('btnAjouter');
let msg = document.getElementById('msg');

filtrerLaSaisie('id', /[0-9]/);
configurerFormulaire();

btnAjouter.onclick = () => {
    msg.innerTEXT = "";
    if (donneesValides()) {
        ajouter();
    }
};

// alimentation des listes déroulantes
for (const element of lesPays){
    idPays.add(new Option(element.nom, element.id));
}

for (const element of lesEcuries){
    idEcurie.add(new Option(element.nom, element.id));
}

// données de test
id.value = 21;
nom.value = "de Vries";
prenom.value = "Nyck";
idPays.value = "nl";
idEcurie.value = 6;
numPilote.value = 3;

function ajouter() {
    let formData = new FormData();
    formData.append('table', 'pilote');
    formData.append('id', id.value);
    formData.append('nom', nom.value);
    formData.append('prenom', prenom.value);
    formData.append('idPays', idPays.value);
    formData.append('idEcurie', idEcurie.value);
    formData.append('numPilote', numPilote.value);
    formData.append('photo', photo.files[0]);

    $.ajax({
        url: 'ajax/ajouter.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: "json",
        success: (data) => {
            if (data.success) {
                // Mise à jour de l'interface
                viderLesChamps();
                afficherSucces("Ajout enregistrée");
            } else {
                for (const key in data.error) {
                    const message = data.error[key];
                    if (key === 'system') {
                        console.log(message);
                        afficherErreur('Une erreur est survenue lors de l\'ajout');
                    } else if (key === 'global') {
                        msg.innerHTML = genererMessage(message);
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

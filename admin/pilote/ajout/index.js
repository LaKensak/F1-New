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
let dateNaissance = document.getElementById('dateNaissance');
let idPays = document.getElementById('idPays');
let idEcurie = document.getElementById('idEcurie');
let numPilote = document.getElementById('numPilote');
let btnAjouter = document.getElementById('btnAjouter');

filtrerLaSaisie('id', /[0-9]/);
configurerFormulaire()


btnAjouter.onclick = () => {
    msg.innerHTML = "";
    if (donneesValides()) {
        ajouter();
    }
}

// alimentation des listes déroulantes
for (const element of lesPays)
    idPays.add(new Option(element.nom, element.id));

for (const element of lesEcuries)
    idEcurie.add(new Option(element.nom, element.id));

// données de  test
id.value = 21;
nom.value = "de Vries";
prenom.value = "Nyck"
idPays.value = "nl";
idEcurie.value = 6;
numPilote.value = 3;
dateNaissance.value = "1995-02-06"


function ajouter() {
    $.ajax({
        url: '/ajax/ajouter.php',
        type: 'POST',
        data: {
            table : 'pilote',
            id: id.value,
            nom: nom.value,
            prenom: prenom.value,
            dateNaissance: dateNaissance.value,
            idPays: idPays.value,
            idEcurie: idEcurie.value,
            numPilote: numPilote.value
        },
        dataType: "json",
        success: (data) => {
            if (data.success) {
                // Mise à jour de l'interface
                viderLesChamps();
                afficherSucces(data.success);
            } else {
                for (const key in data.error) {
                    const message = data.error[key];
                    if (key === 'system') {
                        console.log(message);
                        afficherErreur('Une erreur est survenue lors de l\'ajout');
                    } else if (key === 'global') {
                        msg.innerHTML =  genererMessage(message);
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
    })
}



'use strict';
// Affichage des coureurs dans un tableau triable

/* global data  */

// chargement des données de l'interface
let lesLignes = document.getElementById('lesLignes');

for (const grandPrix of data) {
    // création d'une ligne
    const tr = lesLignes.insertRow();
    tr.style.lineHeight = '2.5rem';

    // colonne pour la date
    let td = tr.insertCell();
    td.style.textAlign = 'center';
    td.innerText = grandPrix.dateFr;

    // colonne pour le pays
    let img = new Image();
    img.src = '/img/pays/' + grandPrix.idPays + '.png';
    img.alt = grandPrix.nomPays;
    img.style.verticalAlign = 'middle';
    tr.insertCell().appendChild(img);

    // colonne pour le nom
    tr.insertCell().innerText = grandPrix.nom;

    // colonne pour le circuit
    td = tr.insertCell();
    td.classList.add('masquer');
    td.innerText = grandPrix.circuit;

    // création d'un bouton pour voir le classement si les résultats sont disponibles
    if (grandPrix.nb > 0) {
        let bouton = document.createElement('button');
        bouton.classList.add('btn', 'btn-sm', 'btn-outline-danger');
        bouton.innerText = 'Classement';
        bouton.onclick = function () {
            document.location.href = '/classementgranprix/indexf.php?id=' + grandPrix.id;
        };
        tr.insertCell().appendChild(bouton);
    } else {

        tr.insertCell().innerText = 'En attente...';
    }
}


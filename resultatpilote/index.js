'use strict';
// Affichage des coureurs dans un tableau triable

/* global data, nomPilote */

// chargement des données de l'interface
let lesLignes = document.getElementById('lesLignes');
let nom = document.getElementById('nom');

nom.innerText = nomPilote;
for (const ecurie of data) {
    // création d'une ligne
    const tr = lesLignes.insertRow();
    tr.style.lineHeight = '2.5rem';


    // colonne pour la place
    let td = tr.insertCell();
    td.style.textAlign = 'center';
    td.innerText = ecurie.dateFr;


    // colonne pour le nom de l'écurie
    tr.insertCell().innerText = ecurie.nomGP;

    // colonne pour les points
    td = tr.insertCell();
    td.style.textAlign = 'right';
    td.style.paddingRight = '50px';
    td.innerText = ecurie.Place;

    // colonne pour le détail
    td = tr.insertCell();
    td.style.textAlign = 'center';
    td.innerText = ecurie.Points;
}


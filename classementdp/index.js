'use strict';
// Affichage des coureurs dans un tableau triable

/* global data  */

// chargement des données de l'interface
let lesLignes = document.getElementById('lesLignes');

for (const ecurie of data) {
    // création d'une ligne
    const tr = lesLignes.insertRow();
    tr.style.lineHeight = '2.5rem';


    // colonne pour la place
    let td = tr.insertCell();
    td.style.textAlign = 'center';
    td.innerText = ecurie.place;


    // colonne pour le nom de l'écurie
    tr.insertCell().innerText = ecurie.nom;

    // colonne pour les points
    td = tr.insertCell();
    td.style.textAlign = 'right';
    td.style.paddingRight = '50px';
    td.innerText = ecurie.point;

    // colonne pour les points par grand prix
    const pointsParGP = ecurie.PointParGP.split(' '); // séparation des points par espace
    const tdPointsParGP = tr.insertCell();
    tdPointsParGP.style.paddingRight = '50px';
    for (const point of pointsParGP) {
        const span = document.createElement('span');
        span.innerText = point;
        span.style.fontSize = '14px';
        span.style.marginRight = '11px'; // espacement entre les points
        tdPointsParGP.appendChild(span);
    }
}

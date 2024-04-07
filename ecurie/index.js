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
    td.innerText = ecurie.placeClassement;


    // colonne pour le nom de l'écurie
    tr.insertCell().innerText = ecurie.nomEcurie;

    // colonne pour les points
    td = tr.insertCell();
    td.style.textAlign = 'right';
    td.style.paddingRight = '50px';
    td.innerText = ecurie.pointClassement;

    // colonne pour le détail
    td = tr.insertCell();
    td.style.textAlign = 'center';
    //
    let a = document.createElement('a');
    let i = document.createElement('i');
    a.appendChild(i);
    td.appendChild(a);

}


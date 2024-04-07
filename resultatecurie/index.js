'use strict';

/* global data, nomEcurie */


// chargement des données de l'interface
let lesLignes = document.getElementById('lesLignes');
let nom = document.getElementById('nom');

nom.innerText = nomEcurie;

for (const resultat of data) {
    // création d'une ligne
    const tr = lesLignes.insertRow();
    tr.style.lineHeight = '2.5rem';


    // colonne pour la date
    let td = tr.insertCell();
    td.style.textAlign = 'center';
    td.innerText = resultat.dateFr;


    // colonne pour le pays
    let img = new Image();
    img.src = '/img/pays/' + resultat.idPays + '.png';
    img.style.verticalAlign = 'middle';
    tr.insertCell().appendChild(img);

    // colonne pour le Grand Prix
    tr.insertCell().innerText = resultat.nom;

    // colonne pour les points
    td = tr.insertCell();
    td.style.textAlign = 'right';
    td.style.paddingRight = '50px';
    td.innerText = resultat.point;

    // colonne pour le détail
    td = tr.insertCell();
    td.style.textAlign = 'center';
    //
    let a = document.createElement('a');
    a.href = '/ecurie/';
    let i = document.createElement('i');
    i.classList.add('bi', 'bi-search');
    // i.className = 'bi bi-search';
    a.appendChild(i);
    td.appendChild(a);
}


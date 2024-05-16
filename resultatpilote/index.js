'use strict';
// Affichage des coureurs dans un tableau triable

/* global data, nomPilote, photoPilote, paysPilote, ecuriePilote, numPilote,nomPays,prenom */

// chargement des données de l'interface
let lesLignes = document.getElementById('lesLignes');
let nom = document.getElementById('nom');
let logo = document.getElementById('photo');
let pays = document.getElementById('pays');
let nationalite = document.getElementById('nomPays');
let ecurie = document.getElementById('ecurie');
let pilote = document.getElementById('pilote');
let numeroPilote = document.getElementById('numpilote');

nom.innerText = nomPilote;
pilote.innerText = nomPilote + ' ' + prenom;
nationalite.innerText = nomPays;
ecurie.innerText = ecuriePilote;
numeroPilote.innerText = numPilote;
// Afficher la photo du pilote
logo.src = '/img/pilote/' + photoPilote;
pays.src = '/img/pays/' + paysPilote + '.png';



for (const ecurie of data) {
    // création d'une ligne
    const tr = lesLignes.insertRow();
    tr.style.lineHeight = '2.5rem';

    // colonne pour la date
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

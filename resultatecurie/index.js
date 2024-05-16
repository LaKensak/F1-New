'use strict';

/* global data, nomEcurie, logoEcurie, paysEcurie,nomPilote, imgVoiture, prenom1, photoPilote,photoPilote1,nomPilote1,prenom2,nomPilote2,idPilote1,idPilote2, PaysPilote1,PaysPilote2  */


// chargement des données de l'interface
let lesLignes = document.getElementById('lesLignes');
let nom = document.getElementById('nom');
let logo = document.getElementById('logo');
let pays = document.getElementById('pays');
let ecurie = document.getElementById('ecurie');
let voiture = document.getElementById('voiture');
let pilote = document.getElementById('pilote');
let piloted = document.getElementById('pilote2');
let numPilote1 = document.getElementById('numPilote1');
let numPilote2 = document.getElementById('numPilote2');
let natio1 = document.getElementById('paysPilote1');
let natio2 = document.getElementById('paysPilote2');
let photo1 = document.getElementById('photo1');
let photo2 = document.getElementById('photo2');



nom.innerText = nomEcurie;
ecurie.innerText = nomEcurie;
pilote.innerText = prenom1 + ' ' + nomPilote1;
piloted.innerText = prenom2 + ' ' + nomPilote2;
numPilote1.innerText = ' ' + idPilote1;
numPilote2.innerText = ' ' + idPilote2;
logo.src = '/img/ecurie/' + logoEcurie;
pays.src = '/img/pays/' + paysEcurie + '.png';
natio1.src = '/img/pays/' + PaysPilote1 + '.png';
natio2.src = '/img/pays/' + PaysPilote2 + '.png';
photo1.src = '/img/pilote/' + photoPilote;
photo2.src = '/img/pilote/' + photoPilote1;

voiture.src = '/img/f1/' + imgVoiture;


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


}


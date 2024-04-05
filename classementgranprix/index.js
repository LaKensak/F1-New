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

    // colonne pour le pays
    let img = new Image();
    img.src = '/img/pays/' + ecurie.idPays + '.png';
    img.title = ecurie.nomPays;
    img.style.verticalAlign = 'middle';
    tr.insertCell().appendChild(img);

    // colonne pour le nom de l'écurie
    tr.insertCell().innerText = ecurie.nom;

    // colonne pour les points
    td = tr.insertCell();
    td.style.textAlign = 'right';
    td.style.paddingRight = '50px';
    td.innerText = ecurie.point;

    // colonne pour le détail
    td = tr.insertCell();
    td.style.textAlign = 'center';
    //
    let a = document.createElement('a');
    a.href = '/resultatecurie/?id=' + ecurie.id;
    let i = document.createElement('i');
    i.classList.add('bi', 'bi-search');
    // i.className = 'bi bi-search';
    a.appendChild(i);
    td.appendChild(a);

    // td.innerHTML = '<a href="resultatecurie"> <i class="bi bi-search"></i></a>';


}


'use strict';
// Affichage des coureurs dans un tableau triable

/* global data  */

// chargement des données de l'interface
let lesLignes = document.getElementById('lesLignes');

for (const pilote of data) {
    // création d'une ligne
    const tr = lesLignes.insertRow();
    tr.style.lineHeight = '2.5rem';

    // colonne pour la place
    let td = tr.insertCell();
    td.style.textAlign = 'center';
    td.innerText = pilote.place;

    // colonne pour le nom de l'écurie
    const nomCell = tr.insertCell();
    nomCell.innerText = pilote.nom;
    nomCell.style.paddingRight = '50px';

    // colonne pour les points
    td = tr.insertCell();
    td.style.textAlign = 'right';
    td.style.paddingRight = '50px';
    td.innerText = pilote.points;

    // colonne pour les points par grand prix
    const pointsParGP = pilote.PointParGP.split(' '); // séparation des points par espace
    const tdPointsParGP = tr.insertCell();
    tdPointsParGP.style.paddingRight = '50px';

    // Ajout d'un événement de survol à chaque point
    for (const point of pointsParGP) {
        // Récupérer l'index de ce point
        const index = pointsParGP.indexOf(point);
        // Récupérer le pays associé à cet index dans les pays participés
        const pays = pilote.pays_participes.split(',')[index];

        // Création de l'élément span pour afficher le point par grand prix
        const span = document.createElement('span');
        span.innerText = point;
        const pointParts = point.split('/');
        const actualPoint = pointParts[0] === '-' ? '-' : pointParts[0];
        const place = pointParts.length > 1 ? pointParts[1] : '';

        span.innerText = actualPoint;
        span.style.fontSize = '14px';
        span.style.marginRight = '10px'; // espacement entre les points

        // Ajouter la partie de la place en petit si elle est disponible
        if (place) {
            const small = document.createElement('small');
            small.innerText = '/' + place.toLowerCase();
            small.style.fontSize = '10px'; // taille de la police plus petite
            span.appendChild(small);
        }

        // Création de l'élément img pour afficher l'image du pays associé
        const img = document.createElement('img');
        img.src = '/img/pays/' + pays + '.png'; // ajustez le chemin en fonction de votre structure de fichiers
        img.alt = pays; // texte alternatif au cas où l'image ne se charge pas
        img.style.width = '20px'; // ajustez la taille de l'image selon vos besoins
        img.style.display = 'none'; // cacher l'image par défaut

        // Ajouter un événement de survol pour afficher l'image du pays associé
        span.addEventListener('mouseover', function() {
            img.style.display = 'inline'; // afficher l'image lorsque survolé
        });

        // Réinitialiser l'image lorsque le survol est terminé
        span.addEventListener('mouseout', function() {
            img.style.display = 'none'; // cacher l'image lorsque le survol est terminé
        });

        tdPointsParGP.appendChild(span); // ajouter le point par grand prix à la cellule
        tdPointsParGP.appendChild(img); // ajouter l'image du pays à la cellule
    }
}

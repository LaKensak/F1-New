'use strict';
// Affichage des coureurs dans un tableau triable

/* global data */

// chargement des données de l'interface
let lesLignes = document.getElementById('lesLignes');

// Création de l'image par défaut
const defaultImg = document.createElement('img');
defaultImg.src = '/img/pays/erreur.png'; // chemin de l'image par défaut
defaultImg.alt = 'Default'; // texte alternatif au cas où l'image ne se charge pas
defaultImg.style.width = '20px'; // ajustez la taille de l'image selon vos besoins

for (const pilote of data) {
    // création d'une ligne
    const tr = lesLignes.insertRow();
    tr.style.lineHeight = '2.5rem';

    // colonne pour la place
    let td = tr.insertCell();
    td.style.textAlign = 'center';
    td.innerText = pilote.place;

    // colonne pour le nom des pilotes
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
    tdPointsParGP.style.paddingRight = '550px';


    // Création d'une cellule pour les images des pays
    const tdImagesPays = document.createElement('td');
    tdImagesPays.style.verticalAlign = 'top'; // alignement vertical au-dessus

    // Ajout d'un événement de survol à chaque point
    for (const point of pointsParGP) {
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
        const paysIndex = pointsParGP.indexOf(point);
        const pays = pilote.pays_participes.split(',')[paysIndex];
        img.src = '/img/pays/' + pays + '.png'; // ajustez le chemin en fonction de votre structure de fichiers
        img.alt = pays; // texte alternatif au cas où l'image ne se charge pas
        img.style.width = '20px'; // ajustez la taille de l'image selon vos besoins
        img.style.display = 'none'; // cacher l'image par défaut

        // Vérifier si l'image est trouvée
        img.onerror = function() {
            img.src = defaultImg.src; // Si l'image n'est pas trouvée, afficher l'image par défaut
        };

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
        tdImagesPays.appendChild(img);
    }
    tr.insertBefore(tdImagesPays, tr.cells[3]);
}

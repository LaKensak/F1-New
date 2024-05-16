'use strict';

let lesLignes = document.getElementById('lesLignes');

for (const grandPrix of data) {
    const tr = lesLignes.insertRow();
    tr.style.lineHeight = '2.5rem';

    let td = tr.insertCell(); // colonne pour la date
    td.style.textAlign = 'center';
    td.innerText = grandPrix.dateFr;

    let img = new Image(); // colonne pour le pays
    img.src = '/img/pays/' + grandPrix.idPays + '.png';
    img.alt = grandPrix.nomPays;
    img.style.verticalAlign = 'middle';
    tr.insertCell().appendChild(img);

    tr.insertCell().innerText = grandPrix.nom; // colonne pour le nom

    td = tr.insertCell(); // colonne pour le circuit
    td.innerText = grandPrix.circuit;
    td.classList.add('masquer');

    // Cellule à droite du circuit
    let tdRight = tr.insertCell();
    tdRight.style.textAlign = 'center';

    // Insérer une image dans la cellule à droite du circuit
    let circuitImage = new Image();
    circuitImage.src = '/img/circuit/' + grandPrix.imgCircuit;
    circuitImage.alt = grandPrix.circuit;
    circuitImage.style.maxHeight = '50px'; // Définissez la hauteur maximale de l'image selon vos besoins
    tdRight.appendChild(circuitImage);

    // Création d'un bouton pour voir le classement si les résultats sont disponibles
    if (grandPrix.nb > 0) {
        let bouton = document.createElement('button');
        bouton.classList.add('btn', 'btn-sm', 'btn-outline-danger');
        bouton.innerText = 'Classement';
        bouton.onclick = function () {
            document.location.href = '/classementgranprix/?id=' + grandPrix.id;
        };
        tr.insertCell().appendChild(bouton);
    } else {
        tr.insertCell().innerText = 'En attente...';
    }
}

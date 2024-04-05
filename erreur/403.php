<?php
// Vérifier si un en-tête HTTP de redirection est présent
if (!isset($_SERVER['REDIRECT_STATUS']) || $_SERVER['REDIRECT_STATUS'] != 403) {
    header('Location: /index.php');
    exit;
}

// activation du chargement dynamique des ressources
require $_SERVER['DOCUMENT_ROOT'] . '/include/autoload.php';

//  affichage de la page
require RACINE . '/include/interface.php';






<?php
// chargement dynamique des ressources
require $_SERVER['DOCUMENT_ROOT'] . "/include/autoload.php";

// contrôle de la transmission des paramètres
if (!isset($_POST['idGrandPrix'])) {
    Erreur::envoyerReponse("Le numéro du grand prix n'est pas transmis", 'system');
}

// récupération et filtrage de la valeur du paramètre
$idGrandPrix = filter_input(INPUT_POST, 'idGrandPrix', FILTER_VALIDATE_INT);
if (!$idGrandPrix) {
    Erreur::envoyerReponse("Le numéro du grand prix n'est pas valide", 'system');
}

// le grand prix doit avoir des résultats
if (!Resultat::estSaisi($idGrandPrix)) {
    Erreur::envoyerReponse("Ce grand prix n'a pas de résultats", 'system');
}

// suppression des résultats
Resultat::supprimer($idGrandPrix);
echo json_encode(['success' => 'Les résultats ont été supprimés']);


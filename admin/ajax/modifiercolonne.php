<?php
// activation du chargement dynamique des ressources
require $_SERVER['DOCUMENT_ROOT'] . "/include/autoload.php";


// vérification de la transmission des données attendues
if (!Std::existe('table', 'id', 'colonne', 'valeur') ) {
    Erreur::envoyerReponse("1", 'system');
}

// récupération des données ; ne pas encoder avec htmlspecialchar sinon pb avec checkvalidity (' par exemple)
$id = $_POST["id"];
$valeur = $_POST["valeur"];
$colonne = $_POST["colonne"];
$table = $_POST['table'];

// Contrôle sur le nom de la classe
if (!class_exists($table)) {
    Erreur::envoyerReponse("2", 'system');
}

// Réalisation de la modification en mode colonne
$table = new $table();

if ($table->modifierColonne($colonne, $valeur, $id)) {
    echo json_encode(['success' => "Modification enregistrée"]);
} else {
    echo json_encode(['error' => $table->getLesErreurs()]);
}

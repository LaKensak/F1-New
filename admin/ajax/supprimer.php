<?php
// activation du chargement dynamique des ressources
require $_SERVER['DOCUMENT_ROOT'] . "/include/autoload.php";

// vérification de la transmission des données attendues
if (!Std::existe('table', 'id') ) {
    Erreur::envoyerReponse('Paramètre manquant', 'system');
}

// récupération des données ; ne pas encoder avec htmlspecialchar sinon pb avec checkvalidity (' par exemple)
$id = $_POST["id"];
$table = $_POST['table'];

// Contrôle sur le nom de la classe
if (! class_exists($table)) {
    Erreur::envoyerReponse("Paramètre invalide", 'system');
}

// Réalisation de la suppression
$table = new $table();
if ($table->delete($_POST['id'])) {
    $reponse = ['success' => "Opération réalisée avec succès"];
} else {
    $reponse = ['error' => $table->getLesErreurs()];
}
echo json_encode($reponse, JSON_UNESCAPED_UNICODE);

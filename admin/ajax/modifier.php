<?php
require $_SERVER['DOCUMENT_ROOT'] . "/include/autoload.php";

if (!Std::existe('table', 'id', 'lesValeurs')) {
    Erreur::envoyerReponse('Requête invalide', 'system');
}

$id = $_POST["id"];
$lesValeurs = json_decode($_POST['lesValeurs'], true);
$table = $_POST['table'];

if (!class_exists($table)) {
    Erreur::envoyerReponse("La classe $table n'existe pas.", 'system');
}

if ($lesValeurs === null) {
    Erreur::envoyerReponse("Un paramètre n'a pas de valeur", 'system');
}

$table = new $table();
if ($table->update($id, $lesValeurs)) {
    $reponse = ['success' => "Opération réalisée avec succès"];
} else {
    $reponse = ['error' => $table->getLesErreurs()];
}
echo json_encode($reponse, JSON_UNESCAPED_UNICODE);

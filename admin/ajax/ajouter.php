<?php
// activation du chargement dynamique des ressources
require $_SERVER['DOCUMENT_ROOT'] . "/include/autoload.php";

// Contrôle sur le nom de la classe
if (!isset($_POST['table']) || ! class_exists($_POST['table'])) {
    Erreur::envoyerReponse("1", 'system');
}

// Réalisation de la modification
$nomClasse = $_POST['table'];

// création d'une instanciation dynamique de classe
$table = new $nomClasse();
// Ajout dans la table en vérifiant que tous les champs sont corrects
if (!$table->donneesTransmises()) {
    $reponse = ['error' => $table->getLesErreurs()];
} elseif (!$table->checkAll()) {
    $reponse = ['error' => $table->getLesErreurs()];
} elseif (!$table->insert()) {
    $reponse = ['error' => $table->getLesErreurs()];
} else {
    if($table->getLastInsertId()) {
        $reponse = ['success' => $table->getLastInsertId()];
    } else {
        $reponse = ['success' => "Opération réalisée avec succès"];
    }
}
echo json_encode($reponse, JSON_UNESCAPED_UNICODE);

<?php
// Modification d'un enregistrement dans une table possédant une clé primaire non composée
// Paramètres attendus
//     table : nom de la table concerné
//     id : valeur de la clé primaire permettant d'identifieer l'enregistrement concernée
//     lesValeurs : des autres champs obligatoires de la table (modifiées ou non)

// activation du chargement dynamique des ressources
require $_SERVER['DOCUMENT_ROOT'] . "/include/autoload.php";

// vérification de la transmission des données attendues
if (!Std::existe('table', 'id', 'lesValeurs') ) {
    Erreur::envoyerReponse('Requête invalide', 'system');
}

// récupération des données ; ne pas encoder avec htmlspecialchar sinon pb avec checkvalidity (' par exemple)
$id = $_POST["id"];
$lesValeurs = json_decode($_POST['lesValeurs'], true);
$table = $_POST['table'];

// Contrôle sur le nom de la classe
if (! class_exists($table)) {
    Erreur::envoyerReponse("La classe $table n'existe pas.", 'system');
}

// vérification des valeurs
if ($lesValeurs === null) {
    Erreur::envoyerReponse("Un paramètre n'a pas de valeur", 'system');
}

// Réalisation de la modification
$table = new $table();
if ($table->update($id, $lesValeurs)) {
    $reponse = ['success' => "Opération réalisée avec succès"];
} else {
    $reponse = ['error' => $table->getLesErreurs()];
}
echo json_encode($reponse, JSON_UNESCAPED_UNICODE);


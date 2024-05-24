<?php
// chargement dynamique des ressources
require $_SERVER['DOCUMENT_ROOT'] . "/include/autoload.php";

// contrôle de la transmission des paramètres
if (!Std::existe('idGrandPrix', 'idPilote', 'classement')) {
    Erreur::envoyerReponse("Paramètres manquants", 'system');
}

// récupération des paramètres
$idGrandPrix = $_POST["idGrandPrix"];
$idPiloteBonus = $_POST["idPilote"];
$classement = json_decode($_POST["classement"]);

// vérification des paramètres
$db = Database::getInstance();

// récupération du nombre de points attribués à la place
$lesPoints = F1::getLesPoints();
$nbPoints = count($lesPoints);

$nbClasses = count($classement);

// parcours du tableau classement par les indices
$place = 1;
foreach ($classement as $idPilote) {
    // mémorisation du meilleur tour
    if ($idPilote == $idPiloteBonus) {
        GrandPrix::setIdPilote($idGrandPrix, $idPilote);
    }
    // détermination des points attribués à la place
    if ($place > $nbPoints) {
        $point = 0;
    } else {
        $point = $lesPoints[$place - 1];
        // faut-il ajouter le point bonus Attention le type n'est pas le même
        if ($idPilote == $idPiloteBonus) {
            $point++;
        }
    }
    // insertion du résultat
    Resultat::ajouter($idGrandPrix, $idPilote, $place, $point);
    // incrémentation de la place
    $place++;
}
echo json_encode(['success' => 'Les résultats ont été ajoutés']);
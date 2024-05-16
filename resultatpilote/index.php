<?php
// activation du chargement dynamique des ressources
require $_SERVER['DOCUMENT_ROOT'] . "/include/autoload.php";

// alimentation de l'interface
$retour = "/";
// récupération et contrôle du format du paramètre transmis
if (!isset($_GET['id'])) {
    Erreur::envoyerReponse("Votre requête n'est pas valide", 'system');
}

$id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
if ($id === false) {
    Erreur::envoyerReponse("La valeur transmise n'est pas de type attendu", 'system');
}

$id = $_GET['id'];



$nomPilote = gp::getNomPilote($id);
if (!$nomPilote) {
    Erreur::envoyerReponse("Votre requête n'est pas valide", 'system');
}

// Récupération  des coureurs : licence, nom prenom, sexe, dateNaissanceFr au format fr, idCategorie, nomClub
$ligne = gp::getClassementP($id);


$lignePilote = gp::getPilotes($id);
if (!$lignePilote) {
    Erreur::envoyerReponse("Votre requête n'est pas valide", 'system');
}

$photoPilote = $lignePilote['photo'];
$paysPilote = $lignePilote['Pays'];
$ecuriePilote = $lignePilote['ecuriePilote'];
$numPilote = $lignePilote['numPilote'];
$nomPays = $lignePilote['nomPays'];
$prenom = $lignePilote['prenom'];
$data = json_encode($ligne);
$head = <<<EOD
<script>
    let data = $data;
    let nomPilote = "$nomPilote";
    let photoPilote = "$photoPilote";
    let paysPilote = "$paysPilote";
    let ecuriePilote = "$ecuriePilote";
    let numPilote = "$numPilote";
    let nomPays = "$nomPays";
    let prenom = "$prenom";
</script>
EOD;


// chargement de l'interface
require RACINE . "/include/interface.php";

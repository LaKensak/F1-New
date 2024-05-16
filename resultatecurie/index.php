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

$nomEcurie = gp::getNomEcurie($id);
if (!$nomEcurie) {
    Erreur::envoyerReponse("Votre requête n'est pas valide", 'system');
}


$ligne = gp::getClassementE($id);

$pilotesData = gp::getPilotesEcurie($id);

$pilote1 = $pilotesData['pilote1'];
$pilote2 = $pilotesData['pilote2'];

$logoEcurie = $pilote1['logo'];
$paysEcurie = $pilote1['Pays'];
$photoPilote = $pilote1['photo'];

$nomPilote1 = $pilote1['nomPilote'];
$prenom1 = $pilote1['prenom'];
$idPilote1 = $pilote1['idPilote'];
$PaysPilote1 = $pilote1['paysPilote'];

$nomPilote2 = $pilote2['nomPilote'];
$prenom2 = $pilote2['prenom'];
$idPilote2 = $pilote2['idPilote'];
$PaysPilote2 = $pilote2['paysPilote'];
$photoPilote1 = $pilote2['photo'];

$imgVoiture = $pilote1['imgVoiture'];

$data = json_encode($ligne);

$head = <<<EOD
<script>
    let data = $data;
    let nomEcurie = "$nomEcurie";
    let logoEcurie = "$logoEcurie";
    let paysEcurie = "$paysEcurie";
    let nomPilote1 = "$nomPilote1";
    let prenom1 = "$prenom1";
    let nomPilote2 = "$nomPilote2";
    let prenom2 = "$prenom2";
    let imgVoiture = "$imgVoiture";
    let photoPilote = "$photoPilote";
    let photoPilote1 = "$photoPilote1";
    let idPilote1 = "$idPilote1";
    let idPilote2 = "$idPilote2";
    let PaysPilote1 = "$PaysPilote1";
    let PaysPilote2 = "$PaysPilote2";
</script>
EOD;

// chargement de l'interface
require RACINE . "/include/interface.php";
?>

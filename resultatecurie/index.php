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


$sql = <<<EOD
   Select nom
   from ecurie
   where id = :id 
EOD;
$select = new Select();
$ligne = $select->getRow($sql, ['id' => $id]);
if (!$ligne) {
    Erreur::envoyerReponse("Votre requête n'est pas valide", 'system');
}


// Récupération  des coureurs : licence, nom prenom, sexe, dateNaissanceFr au format fr, idCategorie, nomClub
$select = new Select();
$nomEcurie = $ligne['nom'];
$sql = <<<EOD
     SELECT DATE_FORMAT(date,'%d/%m/%Y') as dateFr, grandprix.nom,  SUM(resultat.point) as point, grandprix.idPays
                FROM resultat
                JOIN grandprix ON resultat.idGrandprix = grandprix.id
                JOIN pilote ON resultat.idPilote = pilote.id
                WHERE idEcurie = :id
                GROUP BY grandprix.date, grandprix.nom
EOD;
$ligne = $select->getRows($sql, ['id' => $id]);

$sqlEcurie = <<<EOD
        SELECT logo,p.id as Pays,imgVoiture,pilote.nom as nomPilote, pilote.prenom,photo,pilote.id as idPilote,pilote.idPays as paysPilote
        FROM ecurie
        join pays p on ecurie.idPays = p.id
        join pilote on ecurie.id = pilote.idEcurie
        WHERE ecurie.id = :id
EOD;

$lignesPilotes = $select->getRows($sqlEcurie, ['id' => $id]);

if (count($lignesPilotes) < 2) {
    Erreur::envoyerReponse("Il n'y a pas suffisamment de pilotes dans cette écurie", 'system');
}

$pilote1 = $lignesPilotes[0];
$pilote2 = $lignesPilotes[1];

$logoEcurie = $pilote1['logo']; // Utilisation de pilote1 pour le logo
$paysEcurie = $pilote1['Pays']; // Utilisation de pilote1 pour le pays
$photoPilote = $pilote1['photo']; // Utilisation de pilote1 pour la photo


$nomPilote1 = $pilote1['nomPilote'];
$prenom1 = $pilote1['prenom'];
$idPilote1 = $pilote1['idPilote'];
$PaysPilote1 = $pilote1['paysPilote'];

$nomPilote2 = $pilote2['nomPilote'];
$prenom2 = $pilote2['prenom'];
$idPilote2 = $pilote2['idPilote'];
$PaysPilote2 = $pilote2['paysPilote'];
$photoPilote1 = $pilote2['photo']; // Utilisation de pilote1 pour la photo

$imgVoiture = $pilote1['imgVoiture']; // Utilisation de pilote1 pour l'image de la voiture

$data = json_encode($select->getRows($sql, ['id' => $id]));
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

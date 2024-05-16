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
   Select nom,photo
   from pilote
   where id = :id 
EOD;
$select = new Select();
$ligne = $select->getRow($sql, ['id' => $id]);
if (!$ligne) {
    Erreur::envoyerReponse("Votre requête n'est pas valide", 'system');
}


// Récupération  des coureurs : licence, nom prenom, sexe, dateNaissanceFr au format fr, idCategorie, nomClub
$select = new Select();
$nomPilote = $ligne['nom'];
$sql = <<<EOD
     SELECT
    date_format(date,'%d/%m') as dateFr,
    gp.nom AS nomGP,
    p.nom AS Pilote,  -- Choisissez MIN() ou MAX() pour choisir un pilote arbitrairement
    p.idEcurie AS Écurie,  -- Choisissez MIN() ou MAX() pour choisir une écurie arbitrairement
    r.place AS Place,
    r.point AS Points
FROM
    resultat r
JOIN
    grandprix gp ON r.idGrandPrix = gp.id
JOIN
    pilote p ON r.idPilote = p.id
WHERE
    p.id = :id
GROUP BY
    gp.nom;

EOD;

$sqlPilote = <<<EOD
    SELECT photo, pays.id as Pays,e.nom as ecuriePilote,pilote.id as numPilote, pays.nom as nomPays, pilote.prenom as prenom
FROM pilote
join pays on pilote.idPays = pays.id
join ecurie e on pilote.idEcurie = e.id
WHERE pilote.id = :id
EOD;

$lignePilote = $select->getRow($sqlPilote, ['id' => $id]);
if (!$lignePilote) {
    Erreur::envoyerReponse("Votre requête n'est pas valide", 'system');
}
$photoPilote = $lignePilote['photo'];
$paysPilote = $lignePilote['Pays'];
$ecuriePilote = $lignePilote['ecuriePilote'];
$numPilote = $lignePilote['numPilote'];
$nomPays = $lignePilote['nomPays'];
$prenom = $lignePilote['prenom'];
$data = json_encode($select->getRows($sql, ['id' => $id]));
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

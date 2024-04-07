<?php
// activation du chargement dynamique des ressources
require $_SERVER['DOCUMENT_ROOT'] . "/include/autoload.php";

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
   from Ecurie
   where id = :id 
EOD;
$select = new Select();
$ligne = $select->getRow($sql, ['id' => $id]);
if (!$ligne) {
    Erreur::envoyerReponse("Votre requête n'est pas valide", 'system');
}


// alimentation de l'interface
$retour = "/classementecurie";
$nomEcurie = $ligne['nom'];

$sql = <<<EOD

  SELECT date_format(date,'%d/%m/%Y') as dateFr, grandprix.nom,  sum(resultat.point) as point,
          grandprix.idPays
FROM resultat
     JOIN grandprix ON resultat.idGrandprix = grandprix.id
join pilote on resultat.idPilote = pilote.id
where idEcurie = :id
 Group by grandprix.date, grandprix.nom

EOD;
$data = json_encode($select->getRows($sql, ['id' => $id]));

$head = <<<EOD
<script>
    let data = $data;
    let nomEcurie = "$nomEcurie";
</script>
EOD;
//SELECT date_format(date,'%d/%m/%Y') as dateFr, grandprix.nom,  sum(resultat.point) as point,
//           grandprix.idPays
//    FROM resultat
//       JOIN grandprix ON resultat.idGrandprix = grandprix.id
//       join pilote on resultat.idPilote = pilote.id
//    where idEcurie = :id
//    Group by grandprix.date, grandprix.nom
// chargement des ressources spécifiques de l'interface


// chargement de l'interface
require RACINE . "/include/interface.php";

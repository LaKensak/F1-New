<?php
// activation du chargement dynamique des ressources
require $_SERVER['DOCUMENT_ROOT'] . "/include/autoload.php";

// alimentation de l'interface
$retour = "/";

// Récupération  des coureurs : licence, nom prenom, sexe, dateNaissanceFr au format fr, idCategorie, nomClub
$select = new Select();

//   (select count(*) from resultat where idGrandPrix = id) as nb
 $sql = <<<EOD
   SELECT
    pilote.id,
    pilote.nom as piloteNom,
    pilote.idPays,
    pays.nom AS nomPays,
    e.nom AS nomEcurie,
    (SELECT SUM(point)
     FROM classementpilote
     WHERE classementpilote.id = pilote.id
     GROUP BY classementpilote.id) AS point,
    (SELECT COUNT(*) + 1
     FROM (SELECT SUM(point) AS total_points
           FROM classementpilote
           GROUP BY id) AS p
     WHERE total_points > point) AS place
FROM
    pilote
JOIN
    ecurie e ON pilote.idEcurie = e.id
JOIN
    pays ON pilote.idPays = pays.id
ORDER BY
    point DESC;

EOD;

$data = json_encode($select->getRows($sql));
$head = <<<EOD
<script>
    let data = $data;
</script>
EOD;

// chargement des ressources spécifiques de l'interface


// chargement de l'interface
require RACINE . "/include/interface.php";

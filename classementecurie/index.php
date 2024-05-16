<?php
// activation du chargement dynamique des ressources
require $_SERVER['DOCUMENT_ROOT'] . "/include/autoload.php";

// alimentation de l'interface
$retour = "/";

$select = new Select();
$sql = <<<EOD

SELECT
    ecurie.nom AS nomEcurie,
    SUM(resultat.point) AS points,
    (
        SELECT COUNT(*) + 1
        FROM (
            SELECT SUM(point) AS points
            FROM classementecurie
            GROUP BY id
        ) AS e
        WHERE points > SUM(resultat.point)
    ) AS place,
    GROUP_CONCAT(
        CONCAT(IF(resultat.point = 0, '-/', CONCAT(resultat.point, '/')), resultat.place) ORDER BY grandprix.date SEPARATOR '  '
    ) AS PointParGP,
    GROUP_CONCAT(DISTINCT grandprix.idPays) AS pays_participes
FROM
    ecurie
JOIN
    pays ON ecurie.idPays = pays.id
JOIN
    pilote ON ecurie.id = pilote.idEcurie
JOIN
    resultat ON pilote.id = resultat.idPilote
JOIN
    grandprix ON resultat.idGrandprix = grandprix.id
GROUP BY
    ecurie.id
ORDER BY
    points DESC;

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
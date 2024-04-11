<?php
// activation du chargement dynamique des ressources
require $_SERVER['DOCUMENT_ROOT'] . "/include/autoload.php";

// alimentation de l'interface
$retour = "/";

$select = new Select();


$sql = <<<EOD
SELECT
    ecurie.nom,
    SUM(resultat.point) AS total_points,
    (
        SELECT SUM(point)
        FROM classementPilote
        WHERE idEcurie = ecurie.id
        GROUP BY idEcurie
    ) AS point,
    (
        SELECT COUNT(*) + 1
        FROM (
            SELECT SUM(point) AS total_points
            FROM classementPilote
            GROUP BY idEcurie
        ) AS p
        WHERE total_points > SUM(resultat.point)
    ) AS place,
    REPLACE(
    GROUP_CONCAT(
        IF(resultat.point = 0, '-', resultat.point) ORDER BY grandprix.date
    ), ',', '  '
) AS PointParGP

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
    total_points DESC; 
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

<?php
// activation du chargement dynamique des ressources
require $_SERVER['DOCUMENT_ROOT'] . "/include/autoload.php";

// alimentation de l'interface
$retour = "/";

// Récupération  des coureurs : licence, nom prenom, sexe, dateNaissanceFr au format fr, idCategorie, nomClub
$select = new Select();

//   (select count(*) from resultat where idGrandPrix = id) as nb
$sql = <<<EOD
    Select ecurie.id,
       ecurie.nom,
       idPays,
       pays.nom as nomPays,
       (select sum(point)
        from classementPilote
        where idEcurie = ecurie.id
        group by idEcurie)          as point,
       (SELECT COUNT(*) + 1
        FROM (SELECT SUM(point) AS total_points
              FROM classementPilote
              GROUP BY idEcurie) as p
        WHERE total_points > point) AS place
from ecurie
   join pays on ecurie.idPays = pays.id
ORDER BY point DESC;
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

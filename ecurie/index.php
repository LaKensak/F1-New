<?php
// activation du chargement dynamique des ressources
require $_SERVER['DOCUMENT_ROOT'] . "/include/autoload.php";

// alimentation de l'interface
$retour = "/";

$select = new Select();

//   (select count(*) from resultat where idGrandPrix = id) as nb
$sql = <<<EOD
   SELECT classementecurie.id,classementecurie.point,classementecurie.place,classementecurie.nom,f1.resultat.point
   FROM classementecurie
   join f1.resultat r on classementecurie.id = resultat.id
   order by place;
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

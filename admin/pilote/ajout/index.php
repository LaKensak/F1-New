<?php
// activation du chargement dynamique des ressources
require $_SERVER['DOCUMENT_ROOT'] . "/include/autoload.php";

// alimentation de l'interface :
$titreFonction = "Ajout d'un pilote";

// récupération des écuries et des pays
$sql = <<<EOD
    SELECT id, nom
    FROM pays
    ORDER BY nom;
EOD;
$select = new Select();
$lesPays = json_encode($select->getRows($sql));


$sql = <<<EOD
    SELECT id, nom
    FROM ecurie
    ORDER BY nom;
EOD;
$lesEcuries = json_encode($select->getRows($sql));

$head = <<<EOD
<script>
    let lesEcuries = $lesEcuries;
    let lesPays = $lesPays;
</script>
EOD;



// chargement de l'interface
require RACINE . "/admin/include/interface.php";


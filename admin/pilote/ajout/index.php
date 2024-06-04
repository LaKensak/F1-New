<?php
// activation du chargement dynamique des ressources
require $_SERVER['DOCUMENT_ROOT'] . "/include/autoload.php";

// alimentation de l'interface :
$titreFonction = "Ajout d'un pilote";

$lesPilotes = json_encode(pilote::getPhoto());
$lesPays = json_encode(pays::getListe());
$lesEcuries = json_encode(ecurie::getListe());

$head = <<<EOD
<script>
    let lesPays = $lesPays;
    let lesPilotes = $lesPilotes;
    let lesEcuries = $lesEcuries;
</script>
EOD;



// chargement de l'interface
require RACINE . "/admin/include/interface.php";


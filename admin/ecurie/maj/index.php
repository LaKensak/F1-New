<?php
// activation du chargement dynamique des ressources
require $_SERVER['DOCUMENT_ROOT'] . "/include/autoload.php";

// alimentation de l'interface :
$titreFonction = "Modification ou suppression d'une écurie";

// récupération des écuries
$lesEcuries = json_encode(Ecurie::getAll());

// récupération des pays
$lesPays = json_encode(Pays::getListe());

$head = <<<EOD
<script>
    let lesEcuries = $lesEcuries;
    let lesPays = $lesPays;
</script>
EOD;

// chargement de l'interface
require RACINE . "/admin/include/interface.php";


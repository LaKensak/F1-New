<?php
// activation du chargement dynamique des ressources
require $_SERVER['DOCUMENT_ROOT'] . "/include/autoload.php";

// alimentation de l'interface :
$titreFonction = "Modification ou suppression d'un Pilote";

// récupération des pilotes, ecurie , pays
$lesPilotes = json_encode(Pilote::getAll());
$lesEcuries = json_encode(Ecurie::getAll());
$lesPays = json_encode(Pays::getListe());

$head = <<<EOD
<script>
    let lesPilotes = $lesPilotes;
    let lesEcuries = $lesEcuries;
    let lesPays = $lesPays;
</script>
EOD;

// chargement de l'interface
require RACINE . "/admin/include/interface.php";


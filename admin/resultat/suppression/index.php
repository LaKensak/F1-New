<?php
// activation du chargement dynamique des ressources
require $_SERVER['DOCUMENT_ROOT'] . "/include/autoload.php";

// alimentation de l'interface :
$titreFonction = "Suppression d'un résultat";
// récupération des grands prix ayant des résultats
$data = json_encode(GrandPrix::getAvecResultat());

$head = <<<EOD
<script>
    let data = $data;
</script>
EOD;

// chargement des composants

// chargement de l'interface
require RACINE . "/admin/include/interface.php";


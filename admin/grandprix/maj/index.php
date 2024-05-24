<?php
// activation du chargement dynamique des ressources
require $_SERVER['DOCUMENT_ROOT'] . "/include/autoload.php";

// alimentation de l'interface :
$titreFonction = "Modification ou suppression d'un Grand Prix";

// récupération des grands prix
$lesGrandsPrix = json_encode(GrandPrix::getAll());

// intervalle pour la date entre le 01/01/n-1 et le 31/12/n
$annee = date("Y");
$max = "$annee-12-31";
$annee--;
$min = "$annee-01-01";

// récupération des pays
$lesPays = json_encode(Pays::getListe());

$head = <<<EOD
<script>
    let lesGrandsPrix = $lesGrandsPrix;
    let lesPays = $lesPays;
    let min = '$min';
    let max = '$max'
</script>
EOD;

// chargement des composants

// chargement de l'interface
require RACINE . "/admin/include/interface.php";


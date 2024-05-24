<?php
// activation du chargement dynamique des ressources
require $_SERVER['DOCUMENT_ROOT'] . "/include/autoload.php";

// alimentation de l'interface
$titreFonction = "Nouveau Grand Prix";


// récupérer les pays pour alimenter la zone de liste des pays
$sql = <<<EOD
       Select id, nom
        From pays
        order by nom;
EOD;
$select = new Select();
$data = json_encode(Pays::getListe());

// intervalle pour la date entre le 01/01/n-1 et le 31/12/n
$annee = date("Y");
$max = "$annee-12-31";
$annee--;
$min = "$annee-01-01";

$head = <<<EOD
<script>
       let data = $data;
       let min = '$min';
       let max = '$max';
</script>
EOD;

// chargement des ressources spécifiques de l'interface

// chargement de l'interface
require RACINE . "/admin/include/interface.php";



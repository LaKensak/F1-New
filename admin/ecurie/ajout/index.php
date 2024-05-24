<?php
// activation du chargement dynamique des ressources
require $_SERVER['DOCUMENT_ROOT'] . "/include/autoload.php";

// alimentation de l'interface
$titreFonction = "Nouvelle écurie";

// récupérer les pays pour alimenter la zone de liste des pays
$data = json_encode(Pays::getListe());

$head = <<<EOD
<script>
       let data = $data;
</script>
EOD;

// chargement de l'interface
require RACINE . "/admin/include/interface.php";



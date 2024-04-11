<?php
// activation du chargement dynamique des ressources
global $nomEcurie, $data;
require $_SERVER['DOCUMENT_ROOT'] . "/include/autoload.php";
require $_SERVER['DOCUMENT_ROOT'] . "/classetechnique/gp.php";



// alimentation de l'interface
$retour = "/classementecurie";



$head = <<<EOD
<script>
    let data = $data;
    let nomEcurie = "$nomEcurie";
</script>
EOD;



// chargement de l'interface
require RACINE . "/include/interface.php";

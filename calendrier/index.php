<?php
// activation du chargement dynamique des ressources
require $_SERVER['DOCUMENT_ROOT'] . "/include/autoload.php";


$data = json_encode(gp::getCalendrier());

$head = <<<EOD
<script>
    let data = $data;
</script>
EOD;


// chargement de l'interface
require RACINE . "/include/interface.php";

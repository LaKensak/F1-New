<?php
// activation du chargement dynamique des ressources
require $_SERVER['DOCUMENT_ROOT'] . "/include/autoload.php";


$select = new Select();

$sql = <<<EOD
    Select id, date_format(date,'%d/%m') as dateFr, nom, circuit, imgCircuit, idPays,
          if(exists(select 1  from resultat where idGrandPrix = id), 1 , 0) as nb 
    from grandprix 
    order by date 
EOD;

$data = json_encode($select->getRows($sql));
$head = <<<EOD
<script>
    let data = $data;
</script>
EOD;


// chargement de l'interface
require RACINE . "/include/interface.php";

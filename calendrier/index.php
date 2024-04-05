<?php
// activation du chargement dynamique des ressources
require $_SERVER['DOCUMENT_ROOT'] . "/include/autoload.php";

// alimentation de l'interface
$titreFonction = "Affichage des données en mode tableau";
$retour = "../../index.php";

// Récupération  des coureurs : licence, nom prenom, sexe, dateNaissanceFr au format fr, idCategorie, nomClub
$select = new Select();

//   (select count(*) from resultat where idGrandPrix = id) as nb
$sql = <<<EOD
    Select id, date_format(date,'%d/%m') as dateFr, nom, circuit, idPays,
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

// chargement des ressources spécifiques de l'interface

// $head .= file_get_contents(RACINE . "/composant/tablesorter.html");
//$head .= file_get_contents(RACINE . "/composant/datatablebootstrap.html");


// chargement de l'interface
require RACINE . "/include/interface.php";

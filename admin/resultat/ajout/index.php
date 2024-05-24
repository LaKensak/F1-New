<?php
// activation du chargement dynamique des ressources
require $_SERVER['DOCUMENT_ROOT'] . "/include/autoload.php";

// alimentation de l'interface :
$titreFonction = "Saisie des résultats";
// récupération des grands prix

$lesDonnees['lesGrandsPrix']  = GrandPrix::getSansResultat();

// s'il n'y a pas de Grand Prix sans résultat
if (count($lesDonnees['lesGrandsPrix']) == 0) {
    Erreur::envoyerReponse("Il n'y a plus de Grand Prix sans résultat", 'global');
}

// récupération des numéros de pilote et des noms afin de pouvoir contrôler le résulat saisi et alimenter la liste déroulante
$lesDonnees['lesPilotes']  = Pilote::getListe();

$data = json_encode($lesDonnees);

$head = <<<EOD
<script>
    let data = $data;
</script>
EOD;


// chargement de l'interface
require RACINE . "/admin/include/interface.php";


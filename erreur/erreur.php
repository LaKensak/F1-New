<?php
// activation du chargement dynamique des ressources
require $_SERVER['DOCUMENT_ROOT'] . "/include/autoload.php";

// contrôle de l'existence de la variable de session erreur
if (!isset($_SESSION['erreur'])) {
    header('location:/index.php');
    exit;
}

// alimentation de l'interface
$titreFonction = "Erreur rencontrée";
// récupération des informations sur l'erreur
$message = "Page : " . $_SESSION['erreur']['page'] . "<br>" . $_SESSION['erreur']['message'];
// destruction de la variable de session
unset($_SESSION['erreur']);

$head = <<<EOD
    <script>
        let message = "$message";
    </script>
EOD;

// chargement interface
require RACINE . '/include/interface.php';


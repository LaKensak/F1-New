<?php
// vérification que l'appel est bien réalisé par une requête Ajax
// la valeur du champ d'en-tête HTTP X-Requested-With est XMLHttpRequest si la requête est réalisée en Ajax

if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
    Erreur::afficher("L'accès direct à cette ressource est interdit. " . $_SERVER['HTTP_X_REQUESTED_WITH']);
}

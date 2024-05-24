<?php

// Contrôle strict des types des paramètres et du résultat des fonctions
declare(strict_types=1);


/**
 * Classe InputTextarea : contrôle une chaine de caractères
 * @Author : Guy Verghote
 * @Date : 27/04/2024
 */
class InputTextarea extends Input
{
// encoder les balises
    public $EncoderHtml = false;
    public $AcceptHtml = true;
    public $lesBalisesAutorisees = ['<br>','<span>', '<b>', '<i>', '<strong>', '<ul>', '<li>', '<img>', '<a>', '<div>'];

    public function checkValidity(): bool
    {
        if (!parent::checkValidity()) return false;

        if ($this->Value !== null) {
            $valeur = (string)$this->Value;
            // Si la saisie utilise un Rich text Editor, il n'y a pas de danger : les caractères sont remplacées par leur code HTML (htmlSpecialchar)

            // protection contre les failles XSS : on retire le code
            // $filteredData = filter_var($valeur, FILTER_SANITIZE_STRING); // obsolète
            if ($this->EncoderHtml)
                $this->Value = htmlspecialchars($valeur, ENT_QUOTES, 'UTF-8');
            else {
                if(!$this->AcceptHtml) {
                    $this->Value = strip_tags($valeur, $this->lesBalisesAutorisees);
                }
            }
        }
        return true;
    }
}

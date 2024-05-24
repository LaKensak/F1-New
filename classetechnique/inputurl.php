<?php

declare(strict_types=1);


/**
 * Classe InputUrl : contrôle une URL
 * @Author : Guy Verghote
 * @Date : 27/04/2024
 */
class InputUrl extends Input
{
    // attribut permettant de préciser si l'on souhaite vérifier l'existence de l'url
    public $VerifierExistence = false;

    public function checkValidity(): bool
    {
        if (!parent::checkValidity()) {
            return false;
        }
        // si une valeur est transmise, on vérifie le format de l'url mais aussi son existence
        if ($this->Value !== null) {
            $valeur = (string)$this->Value;
            // $correct = preg_match("`((http://|https://)?(www.)?(([a-zA-Z0-9-]){2,}\.){1,4}([a-zA-Z]){2,6}(/([a-zA-Z-_/.0-9#:?=&;,]*)?)?)`", (string)$this->Value);
            // "`((http:\/\/|https:\/\/)?(www.)?(([a-zA-Z0-9-]){2,}\.){1,4}([a-zA-Z]){2,6}(\/([a-zA-Z-_\/\.0-9#:?=&;,]*)?)?)`"
            // if (!$correct) {
            if (!filter_var($valeur, FILTER_VALIDATE_URL)) {
                $this->validationMessage = "URL non valide";
                return false;
            }
            // vérification de l'existence réelle de cette url
            if ($this->VerifierExistence) {
                $f = @fopen($valeur, "r");
                if ($f) {
                    fclose($f);
                    $correct = true;
                } else {
                    // essayons en ajoutant /index.php
                    $f = @fopen($valeur . "/index.php", "r");
                    if ($f) {
                        fclose($f);
                        $correct = true;
                    } else {
                        $correct = false;
                    }
                }
                if (!$correct) {
                    $this->validationMessage = "ne correspond pas à une url existante";
                    return false;
                }
            }
        }
        return true;
    }
}

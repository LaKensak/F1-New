<?php

// Contrôle strict des types des paramètres et du résultat des fonctions
declare(strict_types=1);


/**
 * Classe InputText : contrôle une chaine de caractères
 * @Author : Guy Verghote
 * @Date : 27/04/2024
 */
class InputText extends Input
{
    // expression régulière à respecter
    public $Pattern;
    // nombre minimum de caractères
    public $MinLength;
    // nombre maximum de caractères
    public $MaxLength;

    // la valeur sera convertie en majuscule
    public $EnMajuscule = false;

    // la valeur sera convertie en minuscule
    public $EnMinuscule = false;

    // les accents seront retirés
    public $SupprimerAccent = false;

    // les espaces superflus à l'intérieur de la valeur seront retirés
    public $SupprimerEspaceSuperflu = false;

    // suppression des accents
    // problème avec iconv('UTF-8', 'ASCII//TRANSLIT', $valeur); qui ajoute 'devant les accents
    private function sansAccent($valeur): string
    {
        $lesAccents = [
            'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A',
            'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a',
            'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E',
            'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e',
            'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
            'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
            'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O',
            'Ø' => 'O', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o',
            'ø' => 'o', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U',
            'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'Ý' => 'Y', 'ý' => 'y',
            'ÿ' => 'y', 'Ç' => 'C', 'ç' => 'c', 'Ñ' => 'N', 'ñ' => 'n',
            'Æ' => 'AE', 'æ' => 'ae', 'ß' => 'ss', 'Þ' => 'TH', 'þ' => 'th', 'Ð' => 'DH', 'ð' => 'dh'];
        return strtr($valeur, $lesAccents);
    }


    // nettoyage et contrôle de la valeur
    //
    public function checkValidity(): bool
    {

        // la valeur ne doit pas contenir de balise script : la balise script ainsi que son contenu doivent être éliminés
        if ($this->Value !== null) {
            $this->Value = preg_replace('/<script[^>]*.*?<\/script>/is', '', $this->Value);
        }

        // contrôle sur l'obligation d'avoir une valeur
        if (!parent::checkValidity()) {
            return false;
        }

        // contrôle portant sur la valeur si elle est renseignée
        if ($this->Value !== null) {

            $valeur = (string)$this->Value;

            // doit-on enlever les accents
            if ($this->SupprimerAccent) {
                $valeur = $this->sansAccent($valeur);
            }

            // doit-on enlever les espaces superflus à l'intérieur de la chaine
            if ($this->SupprimerEspaceSuperflu) {
                $valeur = preg_replace('/ {2,}/', ' ', $valeur);
            }

            // mise en forme demandée
            if ($this->EnMajuscule) {
                $valeur = strtoupper($valeur);
            } elseif ($this->EnMinuscule) {
                $valeur = strtolower($valeur);
            }

            if (isset($this->Pattern)) {
                if (!preg_match("/" . $this->Pattern . "/", $valeur)) {
                    $this->validationMessage = "Veuillez respecter le format demandé " . $this->Pattern;
                    return false;
                }
            }
            $nbCar = strlen($valeur);
            if (isset($this->MinLength)) {
                $min = $this->MinLength;

                if ($nbCar < $this->MinLength) {
                    $this->validationMessage = "Veuillez allonger ce texte pour qu'il comporte au moins $min caractères. Il en compte actuellement $nbCar.";
                    return false;
                }
            }
            if (isset($this->MaxLength)) {
                if ($nbCar > $this->MaxLength) {
                    $this->validationMessage = "Veuillez réduire ce texte afin de ne pas dépasser " . $this->MaxLength . " caractères";
                    return false;
                }
            }
            $this->Value = $valeur;
        }
        return true;
    }
}

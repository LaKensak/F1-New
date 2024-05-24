<?php
declare(strict_types=1);


/**
 * Classe InputInt : contrôle un entier
 * @Author : Guy Verghote
 * @Date : 27/04/2024
 */
class InputInt extends Input
{
    // valeur la plus petite
    public $Min;

    // valeur la plus grande
    public $Max;

    public function checkValidity(): bool
    {
        if (!parent::checkValidity()) return false;

        if ($this->Value !== null) {
            $valeur = (string)$this->Value;
            if (!preg_match("/[0-9]+/", $valeur)) {
                $this->validationMessage = "doit être numérique";
                return false;
            }
            $valeur = (int)$this->Value;
            if (isset($this->Min)) {
                if ($valeur < $this->Min) {
                    $this->validationMessage = "ne peut être inférieure à $this->Min";
                    return false;
                }
            }
            if (isset($this->Max)) {
                if ($valeur > $this->Max) {
                    $this->validationMessage = "ne peut être supérieure à $this->Max";
                    return false;
                }
            }
        }
        return true;
    }
}
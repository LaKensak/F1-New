<?php
declare(strict_types=1);


/**
 * Classe InputList : contrôle une valeur qui doit se trouver dans un ensemble de valeur
 * @Author : Guy Verghote
 * @Date : 27/04/2024
 */
class InputList extends Input
{
    // Tableau contenant les valeurs autorisées
    public $Values = [];

    // la valeur sera convertie en majuscule
    public $EnMajsucule = false;

    // la valeur sera convertie en minuscule
    public $EnMinuscule = false;

    public function checkValidity(): bool
    {
        if (!parent::checkValidity()) return false;

        if ($this->Value != null) {
            // mise en forme
            // mise en forme demandée
            if ($this->EnMajsucule)
                $this->Value = strtoupper($this->Value);
            elseif ($this->EnMinuscule)
                $this->Value = strtolower($this->Value);

            if (!in_array($this->Value, $this->Values)) {
                $this->validationMessage = "Veuillez entrer une des valeurs acceptées";
                return false;
            }
        }
        return true;
    }
}
<?php
/**
 * Classe Std : Classe statique permettant l'affichage le contrôle et la conversion des données
 *
 * @Author : Guy Verghote
 * @Version 2024.3
 * @Date : 22/04/2024
 */

class Std
{
    /**
     * Génération d'un message dans une mise en forme bootstrap (class='alert alert-dismissible')
     * Nécessite le composant bootstrap avec la partie js !!!
     * @param string $texte texte à afficher.
     * @param string $couleur couleur de fond : vert, rouge ou orange
     * @return string Chaîne au format HTML
     */

    public static function genererMessage(string $texte, string $couleur = 'rouge'): string
    {
        // détermination de la classe bootstrap à utiliser en fonction de la couleur choisie
        if ($couleur === 'vert') {
            $code = '#1FA055';
            $icone = "bi-check-circle";
        } elseif ($couleur === 'rouge') {
            $code = '#C60800';
            $icone = "bi-x-circle";
        } elseif ($couleur === 'orange') {
            $code = '#FF7415';
            $icone = "bi-exclamation-triangle";
        } else {
            $code = '#FF7415';
            $icone = "bi-exclamation-triangle";
        }
        return <<<EOD
            <div class="alert alert-dismissible fade show" 
                 style="color:white; background-color:$code" 
                 role="alert">
                 <i class="bi $icone" ></i>
                 $texte
                 <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
EOD;
    }

    /**
     * Vérifie l'existence des variables passées par POST ou GET
     * Accepte un nombre variable de paramètres qui représentent les variables dont il faut vérifier l'existence
     * Exemple d'appel : if (!Std::existe('id', 'nom', 'prenom')) {...}
     * @return bool vrai si toutes les clés existent dans le tableau
     */

    public static function existe(): bool
    {
        foreach (func_get_args() as $champ) {
            if (!isset($_REQUEST[$champ])) {
                return false;
            }
        }
        return true;
    }

    /**
     * Suppression des espaces superflus à l'intérieur et aux extrémités d'une chaine.
     * @param string $valeur Chaîne à transformer
     * @return string
     */

    public static function supprimerEspace(string $valeur): string
    {
        // return preg_replace("#[[:space:]]{2,}#", " ", trim($valeur));
        return preg_replace('/ {2,}/', ' ', trim($valeur));
    }

    /**
     * @param string $valeur
     * @return string
     */
    public static function supprimerAccent(string $valeur): string
    {
        // Problème : une apostrophe vient se placer devant les lettres ayant perdu leur accent
        // return iconv('UTF-8', 'ASCII//TRANSLIT', $valeur);
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


    /**
     * Conversion d'une chaine de format jj/mm/aaaa au format aaaa-mm-jj
     * @param string $date au format jj/mm/aaaa
     * @return string Chaîne au aaaa-mm-jj
     */

    public static function encoderDate(string $date): string
    {
        // pour éviter l'usage d'une structure conditionnelle la fonction str_pad offe le moyen d'ajouter éventuellement un 0
        $lesElements = explode('/', $date);
        $mois = str_pad($lesElements[1], 2, '0', STR_PAD_LEFT);
        $jour = str_pad($lesElements[0], 2, '0', STR_PAD_LEFT);
        return "$lesElements[2]-$mois-$jour";
    }

    /**
     * Conversion d'une chaine de format aaaa-mm-jj au format jj/mm/aaaa
     * @param string $date au aaaa-mm-jj
     * @return string au format jj/mm/aaaa
     */
    public static function decoderDate(string $date): string
    {
        return substr($date, 8) . '/' . substr($date, 5, 2) . '/' . substr($date, 0, 4);

    }


    public static function dateFrValide(string $valeur): bool
    {
        $correct = preg_match('`^([0-9]{2})[-/.]([0-9]{2})[-/.]([0-9]{4})$`', $valeur, $tdebut);
        if ($correct) {
            $correct = checkdate($tdebut[2], $tdebut[1], $tdebut[3]) && ($tdebut[3] > 1900);
        }
        return $correct;
    }

    public static function dateMysqlValide(string $valeur): bool
    {
        $correct = preg_match('`^([0-9]{4})-([0-9]{2})-([0-9]{2})$`', $valeur, $tdebut);
        if ($correct) {
            $correct = checkdate($tdebut[2], $tdebut[3], $tdebut[1]) && ($tdebut[1] > 1900);
        }
        return $correct;
    }

    public static function urlValide(string $valeur): bool
    {
        // $correct = preg_match("`((http://|https://)?(www.)?(([a-zA-Z0-9-]){2,}\.){1,4}([a-zA-Z]){2,6}(/([a-zA-Z-_/.0-9#:?=&;,]*)?)?)`", $valeur);
        $correct = preg_match("`(https?://)?(www.)?(([a-zA-Z0-9-]){2,}\.){1,4}([a-zA-Z]){2,6}(/([a-zA-Z-_/.0-9#:?=&;,]*)?)?`", $valeur);
        if (!$correct) {
            return false;
        }
        // vérification de l'existence réelle de cette url
        $f = @fopen($valeur, "r");
        if ($f) {
            fclose($f);
            $correct = true;
        } else {
            $correct = false;
        }
        return $correct;
    }

    public static function emailValide(string $valeur): bool
    {
        // return  preg_match("/^[0-9a-z]([-_.]?[0-9a-z])*@[0-9a-z]([-_.]?[0-9a-z])*\.[a-z]{2,4}$/i", $valeur);
        // nouvelle solution à l'aide de la fonction filter_var
        $correct = filter_var($valeur, FILTER_VALIDATE_EMAIL);
        if (!$correct) {
            return false;
        }
        // vérification de l'existence du domaine
        $domaine = substr(strrchr($valeur, "@"), 1);
        if (!checkdnsrr($domaine, "MX")) {
            return false; // Le domaine ou les enregistrements MX n'existent pas
        }
        return true;
    }

    public static function passwordValide(string $valeur): bool
    {
        return preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/", $valeur) && (strlen($valeur) >= 8);
    }

    public static function codePostalValide(string $valeur): bool
    {
        return preg_match("/^[0-9]{5}$/", $valeur);
    }

    public static function mobileValide(string $valeur): bool
    {
        return preg_match("/^0[67][0-9]{8}$/", $valeur);
    }

    public static function fixeValide(string $valeur): bool
    {
        return preg_match("/^0[1-59][0-9]{8}$/", $valeur);
    }

	public static function telephoneValide(string $valeur): bool
    {
        return preg_match("/^0[1-59][0-9]{8}$/", $valeur) || preg_match("/^0[67][0-9]{8}$/", $valeur);
    }

    public static function tempsValide(string $valeur): bool
    {
        return preg_match("/^0[1-59][0-9]{8}$/", $valeur);
    }

    public static function nomValide(string $valeur): bool
    {
        return preg_match("/^[a-z]+([' -]?[a-z]+)*$/i", $valeur);
    }

    public static function nomAvecAccentValide(string $valeur): bool
    {
        return preg_match("/^[a-zàáâãäåòóôõöøèéêëçìíîïùúûüÿñ]+([ '-]?[a-zàáâãäåòóôõöøèéêëçìíîïùúûüÿñ]+)*$/i", $valeur);
    }

    public static function nombreEntierValide(string $valeur): bool
    {
        return preg_match("/^[0-9]*$/", $valeur);
    }

    public static function nombreReelValide(string $valeur): bool
    {
        return preg_match("/^[-+]?[0-9]+(\.[0-9]+)?$/", $valeur);
    }

    /**
     * Contrôle si la valeur du champ respecte le motif accepté par ce champ
     * la fonction est bloquante : si le format n'existe pas la fonction retourne 0
     * @param string $valeur valeur à controler
     * @param string $format format à respecter
     * @return boolean vrai si le champ $valeur respecte le format $format
     */

    public static function formatValide(string $valeur, string $format): bool
    {
        switch ($format) {
            case 'ville':
            case 'nom':
            case 'prenom':
                // lettre espace tiret apostrophe
                $correct = preg_match("/^[a-z]([ '-]?[a-z])*$/i", $valeur);
                break;
            case 'nomAvecAccent':
            case 'villeAvecAccent':
            case 'prenomAvecAccent':
                $correct = preg_match("/^[a-zàáâãäåòóôõöøèéêëçìíîïùúûüÿñ]([ '-]?[a-zàáâãäåòóôõöøèéêëçìíîïùúûüÿñ])*$/i", $valeur);
                break;
            case 'codePostal':
                $correct = preg_match("/^[0-9]{5}$/", $valeur);
                break;
            case 'rue': // tous sauf : [ # & / * ? < > | \ : + _ ] { } %
                $correct = !preg_match('~[{}[#&"/*?<>|\\\\:\]+_]~', $valeur);
                break;
            case 'email':
                // ancienne solution
                // $correct = preg_match("/^[0-9a-z]([-_.]?[0-9a-z])*@[0-9a-z]([-_.]?[0-9a-z])*\.[a-z]{2,4}$/i", $valeur);
                // nouvelle solution à l'aide de la fonction filter_var
                $correct = filter_var($valeur, FILTER_VALIDATE_EMAIL);
                break;
            case 'entier':
                echo $correct = preg_match("/^[0-9]*$/", $valeur);
                break;
            case 'reel':
                $correct = preg_match("/^[-+]?[0-9]+(\.[0-9]+)?$/", $valeur);
                break;
            case 'tel':
                $correct = preg_match("/^0[1-9][0-9]{8}$/", $valeur);
                break;
            case 'fixe':
                $correct = preg_match("/^0[1-59][0-9]{8}$/", $valeur);
                break;
            case 'mobile':
                $correct = preg_match("/^0[67][0-9]{8}$/", $valeur);
                break;
            case 'dateFr':
                $correct = preg_match('`^([0-9]{2})[-/.]([0-9]{2})[-/.]([0-9]{4})$`', $valeur, $tdebut);
                if ($correct) {
                    $correct = checkdate($tdebut[2], $tdebut[1], $tdebut[3]) && ($tdebut[3] > 1900);
                }
                break;
            case 'dateMysql':
                $correct = preg_match('`^([0-9]{4})-([0-9]{2})-([0-9]{2})$`', $valeur, $tdebut);
                if ($correct) {
                    $correct = checkdate($tdebut[2], $tdebut[3], $tdebut[1]) && ($tdebut[1] > 1900);
                }
                break;
            case 'temps': // [hh]:mm:ss autres séparateurs : '.' ou ','
                $correct = preg_match("/^([0-9]{1,2}[.,:]?)?[0-5][0-9][.,:]?[0-5][0-9]$/", $valeur);
                break;
            case 'url':
                // vérification de l'existence réelle de cette url
                $f = @fopen($valeur, "r");
                if ($f) {
                    fclose($f);
                    $correct = true;
                } else {
                    $correct = false;
                }
                break;
            case 'password':
                $correct = preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/", $valeur) && (strlen($valeur) >= 8);
                break;
            default:
                // si on contrôle un motif inexistant, on bloque !
                $correct = false;
        }
        return $correct;
    }
}

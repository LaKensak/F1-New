<?php
/**
 * Classe Journal : Classe statique permettant de tracer les événements de l'application
 *
 * @Author : Guy Verghote
 * @Version 2024.1
 * @Date : 13/05/2024
 */

class Journal
{

    const REPERTOIRE = ".log";

    /**
     *  Mémoriser un événement dans un fichier log
     * @param string $evenement description de l'événement
     * @param string $journal nom du fichier log utilisé
     */
    public static function enregistrer($evenement, $journal = 'evenement')
    {
        $racine = $_SERVER['DOCUMENT_ROOT'];
        $repertoire = self::REPERTOIRE;
        $fichier = "$racine/$repertoire/$journal.log";
        $date = date('d/m/Y H:i:s');
        $script = $_SERVER['SCRIPT_NAME'];
        $ip = self::getIp();
        $fichier = fopen($fichier, "a");
        fwrite($fichier, "$date;$evenement;$script;$ip\n");
    }

    /**
     * Supprime le fichier log dont le nom est passé en paramètre
     * @param $nom
     */
    public static function supprimer($nom)
    {
        $racine = $_SERVER['DOCUMENT_ROOT'];
        $repertoire = self::REPERTOIRE;
        $fichier = "$racine/$repertoire/$nom.log";
        if (file_exists($fichier)) {
            unlink($fichier);
        } else {
            Erreur::envoyerReponse("le fichier $fichier n'existe pas", 'global');
        }
    }

    /**
     * Retourne les événements du journal passé en paramètre dans un tableau
     * @param $journal
     * @return array
     */
    public static function getLesEvevements($journal = 'evenement')
    {
        $racine = $_SERVER['DOCUMENT_ROOT'];
        $repertoire = self::REPERTOIRE;
        $fichier = "$racine/$repertoire/$journal.log";
        if (!file_exists($fichier)) {
            return [];
        }
        $contenu = file_get_contents($fichier);
        $lignes = explode("\n", $contenu);
        // la dernière ligne est vide, il ne faut pas la prendre en compte
        array_pop($lignes);
        // inverser l'ordre pour avoir le plus récent au début
        $lignes = array_reverse($lignes);
        $nb = count($lignes) ;
        // génération des lignes
        $lesLignes = [];
        for ($i = 0; $i < $nb; $i++) {
            $lesLignes[] = explode(";", $lignes[$i]);
        }
        return $lesLignes;
    }

    /**
     * Retourne l'adresse ip du client connecté à l'application web mais sans garantie
     * @return string
     */
    public static function getIp()  {
        if (isset ($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset ($_SERVER['HTTP_CLIENT_IP'])) {
            return  $_SERVER['HTTP_CLIENT_IP'];
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }
}

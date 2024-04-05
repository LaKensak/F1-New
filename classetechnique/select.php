<?php

/**
 * Classe permettant de gérer toutes les requêtes de consultation de la base de données
 *
 * @Author : Guy Verghote
 * @Version : 2024.1
 * @Date : 14/01/2024
 */
class Select
{

    //  attribut privé pour stocker l'objet Dbo assurant la connexion à la base de données
    private $db; // stocke l'adresse de l'unique objet instanciable

    /*
    -------------------------------------------------------------------------------------------------------------------
    Le constructeur
    --------------------------------------------------------------------------------------------------------------------
    */

    /**
     * Constructeur d'un objet Select
     * @param array $params tableau contenant les paramètres de connexion à la base de données (host, database, user, pwd, port
     * $param est facultatif, sa valeur par défaut est un tableau vide
     * La méthode getInstance utilisera les valeurs par défaut définies dans le fichier config.php si $param est vide
     */
    function __construct(array $params = [])
    {
        $this->db = Database::getInstance($params);
    }

    /*
    -------------------------------------------------------------------------------------------------------------------
    Les méthodes applicables sur un objet de la classe Select
    --------------------------------------------------------------------------------------------------------------------
    */

    /**
     * Retourne dans un tableau numérique le résultat d'une requête SQL retournant plusieurs lignnes
     *  chaque ligne étant un tableau associatif clé = nomcolonne et valeur = valeur de la colonne
     * @param string $sql requête Sql
     * @param array $lesParametres tableau associatif clé = nomcolonne et valeur = valeur transmise
     * @return array
     */
    function getRows(string $sql, array $lesParametres = []): array
    {
        if ($lesParametres === []) {
            $curseur = $this->db->query($sql);
        } else {
            $curseur = $this->db->prepare($sql);
            foreach ($lesParametres as $cle => $valeur) {
                $curseur->bindValue($cle, $valeur);
            }
            $curseur->execute();
        }
        // fecthAll retourne un tableau vide si aucun enregistrement trouvé ou en cas d'erreur
        $lesLignes = $curseur->fetchAll(PDO::FETCH_ASSOC);
        $curseur->closeCursor();
        return $lesLignes;
    }

    /**
     * Retourne dans un tableau associatif  le résultat d'une requête retournant une seule ligne
     * @param string $sql requête Sql
     * @param array $lesParametres tableau associatif clé = nomcolonne et valeur = valeur transmise
     * @return array
     */
    function getRow(string $sql, array $lesParametres = []): array|bool
    {
        if ($lesParametres === []) {
            $curseur = $this->db->query($sql);
        } else {
            $curseur = $this->db->prepare($sql);
            foreach ($lesParametres as $cle => $valeur) {
                $curseur->bindValue($cle, $valeur);
            }
            $curseur->execute();
        }
        // fecthAll retourne un tableau vide si aucun enregistrement trouvé ou en cas d'erreur
        $ligne = $curseur->fetch(PDO::FETCH_ASSOC);
        $curseur->closeCursor();
        return $ligne;
    }

    /**
     * Retourne dans une varaible  le résultat d'une requête retournant une seule valeur
     * @param string $sql requête Sql
     * @param array $lesParametres tableau associatif clé = nomcolonne et valeur = valeur transmise
     * @return mixed la valeur retournée par la requête
     */
    function getValue(string $sql, array $lesParametres = []): mixed
    {
        if ($lesParametres === []) {
            $curseur = $this->db->query($sql);
        } else {
            $curseur = $this->db->prepare($sql);
            foreach ($lesParametres as $cle => $valeur) {
                $curseur->bindValue($cle, $valeur);
            }
            $curseur->execute();
        }
        // fecthAll retourne un tableau vide si aucun enregistrement trouvé ou en cas d'erreur
        $valeur = $curseur->fetchColumn();
        $curseur->closeCursor();
        return $valeur;
    }
}
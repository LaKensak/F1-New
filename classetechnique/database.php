<?php

/**
 * Classe permettant de se connecter à la base de données et d'obtenir une instance de PDO
 *
 * @Author : Guy Verghote
 * @Version : 2024.1
 * @Date : 13/01/2024
 */

class Database
{
    //  attribut privé pour stocker l'unique instance de la classe
    private static $_instance; // stocke l'adresse de l'unique objet instanciable

    /**
     * La méthode statique qui permet d'instancier ou de récupérer l'instance unique
     *  Les valeurs par défaut des paramètres doivent être adaptées à l'application
     * @param array $params tableau associatif contenant les paramètres de connexion
     **/
    public static function getInstance(array $params = []): PDO
    {
        if (is_null(self::$_instance)) {
            $config = require('config.php');

            $dbHost = $param['host'] ?? $config['host'];
            $dbBase = $params['database'] ?? $config['database'];
            $dbUser = $params['user'] ?? $config['user'];
            $dbPassword = $params['password'] ?? $config['password'];
            $dbPort = $params['port'] ?? $config['port'];
            try {
                $chaine = "mysql:host=$dbHost;dbname=$dbBase;port=$dbPort";
                $db = new PDO($chaine, $dbUser, $dbPassword);
                $db->exec("SET NAMES 'utf8'");
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$_instance = $db;
            } catch (PDOException $e) { // à personnaliser
                echo "Accès à la base de données impossible, vérifiez les paramètres de connexion " . $e->getMessage();
                exit();
            }
        }
        return self::$_instance;
    }
}

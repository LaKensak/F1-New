<?php

/**
 * Classe de type singleton permettant de générer un objet DBo unique pour l'application
 *
 * @Author : Guy Verghote
 * @Version : 2    Connexion local ou sur serveur
 */

class Database
{
    private static $_instance; // stocke l'adresse de l'unique objet instanciable

    /**
     * La méthode statique qui permet d'instancier ou de récupérer l'instance unique
     **/
    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            $config = self::getConfigFile();
            $dbHost = $config['host'];
            $dbBase = $config['database'];
            $dbUser = $config['user'];
            $dbPassword = $config['password'];
            $dbPort = $config['port'];
            try {
                $chaine = "mysql:host=$dbHost;dbname=$dbBase;port=$dbPort";
                $db = new PDO($chaine, $dbUser, $dbPassword);
                $db->exec("SET NAMES 'utf8'");
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$_instance = $db;
            } catch (PDOException $e) {
                Erreur::envoyerReponse($e->getMessage(), 'system');
            }
        }
        return self::$_instance;
    }

    private static function getConfigFile()
    {
        // $admin = str_starts_with($_SERVER['SCRIPT_NAME'], '/admin');
        $admin = substr($_SERVER['SCRIPT_NAME'], 0, 6) === '/admin';

        if ($_SERVER['SERVER_NAME'] === 'f1') {
            if($admin) {
                return require dirname(__FILE__) . '/configlocaleadmin.php';
            } else {
                return require dirname(__FILE__) . '/configlocale.php';
            }
        } else {
            if($admin) {
                return require dirname(__FILE__)  . '/configdistanteadmin.php';
            } else {
                return require(dirname(__FILE__) . '/configdistante.php');
            }
        }
    }
}
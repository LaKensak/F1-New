<?php
declare(strict_types=1);

/**
 * Classe Erreur : Classe permettant de générer la réponse du serveur en cas d'erreur détectée
 *
 * @Author : Guy Verghote
 * @Date : 28/02/2024
 */

class Erreur
{
    /**
     * Réponse du serveur en cas de détection d'une erreur
     *
     * Si le script a été appelé directement
     *    La méthode redirige l'utilisateur vers la page erreur/erreur.php
     *    Le message d'erreur et le script (page) à l'origine de l'erreur sont conservés dans une variable de session
     * Si le script a été appelé par un appel Ajax
     *    La méthode retourne le message et le type du message dans le format json
     *    Si le type n'est pas précisé, il est déduit à partir du contenu du message
     * @param string $message message associé au type de l'erreur
     * @param string|null $type [facultatif] type de l'erreur :  'global' ou 'system'
     * @return void
     */
    public static function envoyerReponse(string $message, string $type = null): void
    {
        // Si le script a été appelé directement
        if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
            $_SESSION['erreur'] = [];
            $_SESSION['erreur']['page'] = $_SERVER['PHP_SELF'];
            $_SESSION['erreur']['message'] = $message;
            header("Location:/erreur/erreur.php");
        } else {
            // si le type n'est pas défini, il peut s'agir d'une erreur déclenchée par un trigger ou d'une erreur système
            if ($type === null) {
                // recherche de la présence d'un # qui signale un message provenant d'un déclencheur
                $messageDeclencheur = strstr($message, '#');
                if ($messageDeclencheur) {
                    $type = 'global';
                    $message = substr($messageDeclencheur, 1);
                } else {
                    $type = 'system';
                }
            }
            $lesErreurs[$type] = $message;
            echo json_encode(['error' => $lesErreurs], JSON_UNESCAPED_UNICODE);
        }
        exit;
    }
}
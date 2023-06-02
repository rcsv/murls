<?php
declare(strict_types=1);
/**
 * Forwarder.php
 * -----------------------------------------------------------------------
 * Forwarder class
 * 
 * This class is used to forward the request to the appropriate controller
 * based on the URL.
 */
namespace Rcsvpg\Murls;

use PDO;
use PDOException;

class Forwarder
{
    // pdo options
    private static $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    // pdo instance
    private $pdo;

    public function __construct()
    {
        // load environment file
        $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();

        // set dsn strings
        $dsn = $_ENV['DB_DRIVER'] . 
            ':host='   . $_ENV['DB_HOST'] .
            ';dbname=' . $_ENV['DB_NAME'] .
            ';charset='. $_ENV['DB_CHAR'] ;

        // create pdo instance
        try {
            $this->pdo = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASS'], self::$options);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
            exit;
        }
    }

    public function getURL(string $short_url) : string
    {
        // short_url contains slash character at the beginning, remove it
        $short_url = ltrim($short_url, '/');

        // make statement and execute
        $stmt = $this->pdo->prepare('SELECT id, longurl FROM urls WHERE title = :short_url');
        $stmt->bindValue(':short_url', $short_url, PDO::PARAM_STR);
        $stmt->execute();

        // fetch result
        $result = $stmt->fetch();

        // return longurl if exists, otherwise return empty string
        if ( $result ) {
            // update the number of times the short URL has been accessed
            $stmt = $this->pdo->prepare('INSERT INTO stats (url_id, ip, user_agent, referer) VALUES (:url_id, :ip, :user_agent, :referer)');

            // bindings
            $stmt->bindValue(':url_id',     $result['id'],              PDO::PARAM_INT);
            $stmt->bindValue(':ip',         $_SERVER['REMOTE_ADDR'],    PDO::PARAM_STR);
            $stmt->bindValue(':user_agent', $_SERVER['HTTP_USER_AGENT'],PDO::PARAM_STR);
            $stmt->bindValue(':referer',    $_SERVER['HTTP_REFERER'] ?? '',   PDO::PARAM_STR);
            $stmt->execute();

            // return longurl
            return $result['longurl'];
        }

        // return empty string
        return '';

    }

    /**
     * Forwarding method
     * Redirect to the specified URL when the URL is valid.
     * 
     * @param string $url URL to redirect
     * @return false if the URL is invalid
     */
    public static function forwarding(string $url) : bool
    {
        if(!empty($url) && filter_var($url, FILTER_VALIDATE_URL) !== false) {
            header('Location: ' . $url);
            exit;
        }
        return false;
    }
}
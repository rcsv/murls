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
    private static $pdo;

    public function __construct()
    {
        // load environment file
        $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();

        // set dsn strings
        $dsn = 'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'] . ';charset=utf8mb4';

        // create pdo instance
        try {
            self::$pdo = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASS'], self::$options);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
            exit;
        }
    }

    public function getURL(string $short_url) : string
    {
        // hard-coded URL
        return "https://www.yahoo.com/";
    }

    /**
     * Forwarding method
     * Redirect to the specified URL when the URL is valid.
     * 
     * @param string $url URL to redirect
     * @return false if the URL is invalid
     */
    public static function forwarding(string $url) : false
    {
        if(!empty($url) && filter_var($url, FILTER_VALIDATE_URL) !== false) {
            header('Location: ' . $url);
            exit;
        }
        return false;
    }
}
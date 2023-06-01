<?php
declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', '1');

/**
 * public/index.php
 * -----------------------------------------------------------------------
 * Entrypoint of this application
 * 
 * URL shortening service
 * https://mur.ls/ 直下にショートコードがあった場合は、
 * 短縮URLモードとして動作し、ショートコードに対応するURLにリダイレクト
 * 
 * https://mur.ls/user/ ディレクトリにアクセスした場合、
 * または urls ディレクトリにアクセスした場合は、
 * 短縮URLの管理画面として動作する
 */
use Slim\Factory\AppFactory;

require_once __DIR__ . '/../vendor/autoload.php';

// Load container settings
require_once __DIR__ . '/../config/settings.php';

// Create App instance
$app = AppFactory::create();

// Load Routing methods
require_once __DIR__ . '/../config/routes.php';

// Run App
$app->run();
<?php
declare(strict_types=1);

use Slim\Factory\AppFactory;
use DI\ContainerBuilder;
use Rcsvpg\Murls\Application\ResponseEmitter\ResponseEmitter;
use Psr\Log\LoggerInterface;

require_once __DIR__ . '/../vendor/autoload.php';

error_reporting(E_ALL);
ini_set('display_errors', '1');

$containerBuilder = new ContainerBuilder();
if (false) {
    $containerBuilder->enableCompilation(__DIR__ . '/../var/cache');
}

// load settings
$settings = require_once __DIR__ . '/../config/01-settings.php';
$settings($containerBuilder);

// load logger-related settings
$logger = require_once __DIR__ . '/../config/02-dependencies.php';
$logger($containerBuilder);

// Build Container and Create App Instance
$container = $containerBuilder->build();
AppFactory::setContainer($container);
$app = AppFactory::create();

// Add Middleware
$middleware = require_once __DIR__ . '/../config/03-middleware.php';
$middleware($app);

// Load Routing methods
$routes = require_once __DIR__ . '/../config/04-routing.php';
$routes($app);

// extract logger instance to global variable
global $logger;
$logger = $container->get(LoggerInterface::class);

// Run App
$app->run();
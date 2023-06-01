<?php
// config/settings.php
declare(strict_types=1);

// make Twig setting with DI\ContainerBuilder
use DI\Container;
use Slim\Views\Twig;
use Slim\Factory\AppFactory;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// make DI Container
$container = new Container();

// 1.
// Set Twig setting
$container->set('view', 
    function () {
        $twig_options = [
            'cache' => __DIR__ . '/../var/cache',
            'debug' => true,
            'auto_reload' => true,
        ];
        $twig = Twig::create(__DIR__ . '/../templates', $twig_options);
        return $twig;
    });

// 2.
// Set Logger setting
$container->set('logger', 
    function () {
        $logger = new Logger('murls_logger_debug');
        $file_handler = new StreamHandler(__DIR__ . '/../var/logs/app.log');
        $logger->pushHandler($file_handler);
        return $logger;
    });



// Set container to AppFactory
AppFactory::setContainer($container);


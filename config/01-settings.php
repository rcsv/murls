<?php
declare(strict_types=1);

use Rcsvpg\Murls\Application\Settings\Settings;
use Rcsvpg\Murls\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;

use Dotenv\Dotenv;

return function (ContainerBuilder $containerBuilder) {

    // Load environment variables
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();

    // global settings object
    $containerBuilder->addDefinitions([
        SettingsInterface::class => function () {
            return new Settings([
                'name' => 'URL Shortening Service',
                'version' => '0.0.1',
                'displayErrorDetails' =>    $_ENV['DEBUG'],
                'logError' =>               true,
                'logErrorDetails' =>        $_ENV['DEBUG'],
                'logger' => [
                    'name' => 'murls',
                    'path' => __DIR__ . '/../var/logs/app.log',
                    'level' => \Monolog\Logger::DEBUG,
                ],
                'db' => [
                    'driver' =>    $_ENV['DB_DRIVER'],
                    'host' =>      $_ENV['DB_HOST'],
                    'database' =>  $_ENV['DB_NAME'],
                    'username' =>  $_ENV['DB_USER'],
                    'password' =>  $_ENV['DB_PASS'],
                    'charset' =>   $_ENV['DB_CHAR'],
                    'collation' => $_ENV['DB_COLLATION'],
                    'flags' => [
                        PDO::ATTR_PERSISTENT => false,
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false,
                    ],
                ],
                'twig' => [
                    'path' => __DIR__ . '/../templates',
                    'cache_enabled' => false,
                    'cache_path' => __DIR__ . '/../var/cache/twig',
                    'debug' => $_ENV['DEBUG'],
                    'auto_reload' => true,
                ],
                'blade' => [
                    'view_path' => __DIR__ . '/../templates',
                    'cache_path' => __DIR__ . '/../var/cache/blade',
                ],

            ]);
        }
    ]);
};

<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Rcsvpg\Murls\Application\Settings\SettingsInterface;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Processor\UidProcessor;

use Slim\Views\Twig;


return function (ContainerBuilder $containerBuilder) {

    // Load Logger settings
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);

            $loggerSettings = $settings->get('logger');
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },
        'view' => function () {
            return Twig::create(__DIR__ . '/../templates', [
                'cache' => __DIR__ . '/../var/cache/twig',
                'debug' => $_ENV['DEBUG'],
                'auto_reload' => true,
            ]);
        }
    ]);
};
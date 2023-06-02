<?php
declare(strict_types=1);

use Rcsvpg\Murls\Application\Middleware\SessionMiddleware;
use Rcsvpg\Murls\Application\Settings\SettingsInterface;

use Slim\App;
use Slim\Views\TwigMiddleware;

return function (App $app) {

    // get container
    // SettingsInterface::class
    $settings = $app->getContainer()->get(SettingsInterface::class);

    // Session Start
    $app->add(SessionMiddleware::class);

    // Add Routing Middleware
    $app->addRoutingMiddleware();

    // Error Handling Middleware
    $errorMiddleware = $app->addErrorMiddleware(
        (bool)$settings->get('displayErrorDetails'),    // displayErrorDetails
        (bool)$settings->get('logError'),               // logError - always true
        (bool)$settings->get('logErrorDetails')         // logErrorDetails
    );

    // Twig Middleware
    // in route :
    // return $this->get('view')->render($response, 'home.twig', $args);
    $app->add(TwigMiddleware::createFromContainer($app));
};
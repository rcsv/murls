<?php
declare(strict_types=1);

use Rcsvpg\Murls\Application\Middleware\SessionMiddleware;
use Slim\App;
use Slim\Views\TwigMiddleware;

return function (App $app) {

    // Session Start
    $app->add(SessionMiddleware::class);

    // Add Routing Middleware
    $app->addRoutingMiddleware();

    // Error Handling Middleware
    $errorMiddleware = $app->addErrorMiddleware(
        (bool)$_ENV['DEBUG'], // displayErrorDetails
        true, // logErrors - always true
        (bool)$_ENV['DEBUG']  // logErrorDetails
    );

    // Twig Middleware
    // in route :
    // return $this->get('view')->render($response, 'home.twig', $args);
    $app->add(TwigMiddleware::createFromContainer($app));
};
<?php
declare(strict_types=1);
// config/routes.php
// -----------------------------------------------------------------------

// Import the Forwarder class from the Rcsvpg\Murls\Controller namespace
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteCollectorProxy as Group;

use Rcsvpg\Murls\Forwarder;

$app->group('', function (Group $group) {

    //
    // TOP PAGE / HOME PAGE
    //
    $group->get('/', function (Request $request, Response $response, array $args) : Response {
        $response->getBody()->write("Hello, world!");
        return $response;
    });

    $group->any('/info', function (Request $request, Response $response, array $args) : Response {
        phpinfo();
    });
});

//
// short URL mode
// start with none slash, end with slash, and slash with any characters
// e.g. https://mur.ls/abc123
//
$app->any('/{short_code}', function (Request $request, Response $response, array $args) : Response{
    $forwarder = new Forwarder();
    $url = $forwarder->getURL($args['short_code']);
    
    if(Forwarder::forwarding($url)) {
        return $response->redurect($url, 302);
    } else {
        $response->getBody()->write("Invalid URL");
        return $response->withStatus(404);
    }
});

// URL management mode
$app->group('/user', function (Group $group) {
    $group->get('/{id}', function (Request $request, Response $response, $args) {
        $response->getBody()->write("Hello, " . $args['id']);
        return $response;
    });
});

$app->group('/urls', function (Group $group) {
    $group->get('/{id}', function (Request $request, Response $response, $args) {
        $response->getBody()->write("Hello, " . $args['id']);
        return $response;
    });
});

//

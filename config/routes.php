<?php
declare(strict_types=1);
// config/routes.php
// -----------------------------------------------------------------------

// Import the Forwarder class from the Rcsvpg\Murls\Controller namespace
use Psr\Http\Message\ResponseInterface as IResponse;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;

use Slim\Routing\RouteCollectorProxy as Group;
use Slim\Exception\HttpNotFoundException;
use Slim\Psr7\Response;

use Rcsvpg\Murls\Forwarder;

$app->group('', function (Group $group) {

    //
    // TOP PAGE / HOME PAGE
    //
    $group->get('/', function (Request $request, IResponse $response, array $args) : IResponse {
        $response->getBody()->write("Hello, world!");
        return $response;
    });

    $group->any('/info', function (Request $request, IResponse $response, array $args) : IResponse {
        phpinfo();
    });
});

//
// short URL mode
// start with none slash, end with slash, and slash with any characters
// e.g. https://mur.ls/abc123
//
$app->any('/{short_code}', function (Request $request, IResponse $response, array $args) : IResponse {
    $forwarder = new Forwarder();
    $url = $forwarder->getURL($args['short_code']);
    
    if(Forwarder::forwarding($url)) {
        return $response->redurect($url, 302);
    } else {
        $response->getBody()->write("Invalid short code");
        return $response->withStatus(400);
    }
});

// URL management mode
$app->group('/user', function (Group $group) {
    $group->get('/{id}', function (Request $request, IResponse $response, $args) : IResponse {
        $response->getBody()->write("Hello, " . $args['id']);
        return $response;
    });
});

$app->group('/urls', function (Group $group) {
    $group->get('/{id}', function (Request $request, IResponse $response, $args) : IResponse {
        $response->getBody()->write("Hello, " . $args['id']);
        return $response;
    });
});

// add catch HttpNotFoundException
$app->addRoutingMiddleware();

// addRoutingMiddleware() must be called before add(function() {})
$app->add(function (Request $request, RequestHandlerInterface $handler) {

    try {
        return $handler->handle($request);
    } catch (HttpNotFoundException $e) {

        // generate 404 page
        // use Slim\Psr7\Response; -- import Response class
        $response = new Response();
        $response->getBody()->write("Page not found");
        return $response->withStatus(404);
    }
});

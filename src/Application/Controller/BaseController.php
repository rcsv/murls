<?php
declare(strict_types=1);

namespace Rcsvpg\Murls\Application\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Rcsvpg\Murls\Forwarder;

class BaseController extends AbstractController
{
    public function index(Request $request, Response $response, array $args) : Response
    {
        $response->getBody()->write(__CLASS__ . ':' . __FUNCTION__);
        return $response;
    }

    public function stub(Request $request, Response $response, array $args) : Response
    {
        $response->getBody()->write(__CLASS__ . ':' . __FUNCTION__);
        return $response;
    } 

    public function info(Request $request, Response $response, array $args) : Response
    {
        phpinfo();
    }

    public function redirect(Request $request, Response $response, array $args) : Response
    {
        $fowarder = new Forwarder();
        if(Forwarder::forwarding($args['short_url'])) {
            return $response->redurect($url, 302);
        } else {
            $response->getBody()->write("Invalid short code");
            return $response->withStatus(400);
        }

        // TODO: implement redirect using DI\Container

    }
}
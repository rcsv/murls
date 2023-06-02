<?php
declare(strict_types=1);

namespace Rcsvpg\Murls\Application\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Rcsvpg\Murls\Forwarder;

class BaseController extends AbstractController
{
    public function __construct()
    {
        parent::__construct();
        $this->logger->debug(__CLASS__ . ':' . __FUNCTION__);
        $this->logger->info(__CLASS__ . ':' . __FUNCTION__);
    }


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

    /**
     * URL Shortener
     */
    public function redirect(Request $request, Response $response, array $args) : Response
    {
        $fowarder = new Forwarder();
        $url = $fowarder->getURL($args['short_url']);

        if(!Forwarder::forwarding($url)) {
            $response->getBody()->write("Invalid short code");
            return $response->withStatus(400);
        }
    }
}
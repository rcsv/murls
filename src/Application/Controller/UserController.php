<?php
declare(strict_types=1);

namespace Rcsvpg\Murls\Application\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UserController extends AbstractController
{
    public function index(Request $request, Response $response, array $args): Response
    {
        $this->logger->info("User index page action dispatched");

        $this->view->render($response, 'user/index.twig');

        return $response;
    }
}
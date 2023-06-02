<?php
declare(strict_types=1);

namespace Rcsvpg\Murls\Application\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UrlController extends AbstractController
{
    public function index(Request $request, Response $response, array $args): Response
    {
        $this->logger->info("UrlController '/' route");

        $this->view->render($response, 'index.twig');

        return $response;
    }
}
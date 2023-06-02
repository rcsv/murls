<?php
declare(strict_types=1);

namespace Rcsvpg\Murls\Application\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

abstract class AbstractController
{
    protected $logger;

    public function __construct()
    {
        global $logger;
        $this->logger = $logger;
    }

    // have to implement this method in child class
    public abstract function index(Request $request, Response $response, array $args) : Response;
}
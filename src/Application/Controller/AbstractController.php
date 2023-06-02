<?php
declare(strict_types=1);

namespace Rcsvpg\Murls\Application\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

abstract class AbstractController
{
    protected $logger;
    protected $container;
    protected $pdo;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->logger = $container->get(LoggerInterface::class);
        $this->pdo = $container->get(\PDO::class);
    }

    // have to implement this method in child class
    public abstract function index(Request $request, Response $response, array $args) : Response;
}
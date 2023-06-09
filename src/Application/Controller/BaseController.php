<?php
declare(strict_types=1);

namespace Rcsvpg\Murls\Application\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Rcsvpg\Murls\Forwarder;
use Psr\Container\ContainerInterface;

class BaseController extends AbstractController
{
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->logger->debug(__CLASS__ . ':' . __FUNCTION__);
        $this->logger->info(__CLASS__ . ':' . __FUNCTION__);

        // Repository NULL
        // $this->repository = $container->get(Repository::class);
    }


    public function index(Request $request, Response $response, array $args) : Response
    {
        $response->getBody()->write(__CLASS__ . ':' . __FUNCTION__);
        return $response;
    }

    public function stub(Request $request, Response $response, array $args) : Response
    {
        $this->logger->debug(__CLASS__ . ':' . __FUNCTION__);
        return $this->view($response, 'auth.home', ['name' => 'John Doe']);
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
        /**
         * @var Forwarder
         */
        // ltrim slash
        $short = ltrim($args['short'], '/');
        // getURL
        $stmt = $this->pdo->prepare('SELECT id, longurl FROM urls WHERE title = :short');
        $stmt->execute(['short' => $short]);
        $url = $stmt->fetch();

        // if exists insert referes values into stat table and redirect
        if ($url) {
            $stmt = $this->pdo->prepare('INSERT INTO stats (url_id, ip, user_agent, referer) VALUES (:url_id, :ip, :user_agent, :referer)');
            $stmt->execute([
                'url_id' => $url['id'], 
                'ip' => $_SERVER['REMOTE_ADDR'],
                'user_agent' => $_SERVER['HTTP_USER_AGENT'],
                'referer' => $_SERVER['HTTP_REFERER'] ?? '',
            ]);
        
            // redirect $url with 302
            return $response
                ->withHeader('Location', $url['longurl'])
                ->withStatus(302);
        }

        // if not exists display 418
        $response->getBody()->write('418 I\'m a teapot');
        return $response
            ->withHeader('Content-Type', 'text/html')
            ->withStatus(418);

    }
}
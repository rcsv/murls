<?php
declare(strict_types=1);

namespace Rcsvpg\Murls\Application\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Container\ContainerInterface;

use Rcsvpg\Murls\Model\User\UserRepository;

class UserController extends AbstractController
{
    
    private function init()
    {
        if( !isset($this->repository) ) {
            $this->repository = new UserRepository($this->container);
        }
    }

    public function index(Request $request, Response $response, array $args): Response
    {
        return $this->view($response, 'auth.register', ['name' => 'John Doe']);
    }

    public function signup(Request $request, Response $response, array $args): Response
    {
        // make name, email, password available in view
        return $this->view($response, 'auth.register', ['email' => '', 'password' => '', 'errors' => [] ]);
    }

    public function signupPost(Request $request, Response $response, array $args): Response
    {
        $this->logger->debug(__CLASS__ . ':' . __FUNCTION__);
        $this->logger->debug(print_r($request->getParsedBody(), true));

        // prepare data
        $this->init();

        // return error when $repository->findByTitle($request->getParseBody()['email']);
        $email = $request->getParsedBody()['email'];
        $password = $request->getParsedBody()['password'];
        $password_confirmation = $request->getParsedBody()['password_confirmation'];

        $errors = [];
        if( $password !== $password_confirmation ) {
            $errors[] = 'Password does not match';
        }

        if( count($errors) > 0 ) {
            return $this->view($response, 'auth.register', ['email' => $email, 'password' => $password, 'errors' => $errors ]);
        }

        // create user
        $this->repository->create($email, $password);

        
        return $this->view($response, 'auth.register', ['name' => 'John Doe']);
    }


}

/**
 * CREATE TABLE users (
 * id bigint unsigned NOT NULL AUTO_INCREMENT,
 * email varchar(255) NOT NULL,
 * password varchar(255) NOT NULL,
 * verifyurl varchar(100) default null,
 * verified tinyint(1) default 0,
 * created datetime default current_timestamp,
 * updated datetime default current_timestamp on update current_timestamp,
 * deleted datetime default null
 * PRIMARY KEY (id),
 * UNIQUE KEY (email)
 * ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
 */
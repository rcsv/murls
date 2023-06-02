<?php
declare(strict_types=1);

namespace Rcsvpg\Murls\Application\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UserController extends AbstractController
{
    public function index(Request $request, Response $response, array $args): Response
    {
        return $this->view($response, 'auth.register', ['name' => 'John Doe']);
    }

    public function signup(Request $request, Response $response, array $args): Response
    {
        return $this->view($response, 'auth.register', ['name' => 'John Doe']);
    }

    public function signupPost(Request $request, Response $response, array $args): Response
    {
        // store the newly registered user.
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
<?php
declare(strict_types=1);
// Path: config/04-routing.php
use Slim\App;
use Slim\Routing\RouteCollectorProxy as Group;
use Rcsvpg\Murls\Application\Controller\BaseController;
use Rcsvpg\Murls\Application\Controller\UserController;
use Rcsvpg\Murls\Application\Controller\UrlController;

return function (App $app) {

    // mode:
    // 1. normal mode
    // 2. URL Shortener mode
    // 3. service management mode

    // 1. normal mode
    $app->group('', function (Group $group){
        $group->get('/',    [BaseController::class, 'stub'])->setName('home');
        $group->any('/info',[BaseController::class, 'info'])->setName('info');
    });

    // 2. URL Shortener mode
    $app->any('/{short:[a-zA-Z0-9-_]{1,32}}', [BaseController::class, 'redirect'])->setName('redirect');

    // 3. service management mode
    $app->group('/user', function(Group $group) {

        // display login form
        $group->get('/', [UserController::class, 'index'])->setName('index');

        $group->get('/login', [UserController::class, 'login'])->setName('login');

        // display registration form
        $group->get('/register', [UserController::class, 'register'])->setName('register');

        // process registration form
        $group->post('/register', [UserController::class, 'registerPost'])->setName('registerPost');

    });
};
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
        $group->get('/login',   [UserController::class, 'login'])->setName('login');
        $group->post('/login',  [UserController::class, 'loginPost'])->setName('loginPost');
        $group->get('/logout',  [UserController::class, 'logout'])->setName('logout');
        $group->get('/signup',  [UserController::class, 'signup'])->setName('signup');
        $group->post('/signup', [UserController::class, 'signupPost'])->setName('signupPost');

        // Update and Delete
        $group->get('/update',  [UserController::class, 'update'])->setName('update');
        $group->post('/update', [UserController::class, 'updatePost'])->setName('updatePost');

        $group->get('/delete',  [UserController::class, 'delete'])->setName('delete');
        $group->post('/delete', [UserController::class, 'deletePost'])->setName('deletePost');

    });

    $app->group('/urls', function(Group $group) {
        $group->get('/list',    [UrlController::class, 'list'])->setName('list');
        $group->get('/create',  [UrlController::class, 'create'])->setName('create');
        $group->post('/create', [UrlController::class, 'createPost'])->setName('createPost');

        // Update and Delete
        $group->get('/update',  [UrlController::class, 'update'])->setName('update');
        $group->post('/update', [UrlController::class, 'updatePost'])->setName('updatePost');

        $group->get('/delete',  [UrlController::class, 'delete'])->setName('delete');
        $group->post('/delete', [UrlController::class, 'deletePost'])->setName('deletePost');

    });

};
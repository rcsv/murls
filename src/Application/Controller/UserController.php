<?php
declare(strict_types=1);
// path: src/Application/Controller/UserController.php
namespace Rcsvpg\Murls\Application\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Container\ContainerInterface;
use Rcsvpg\Murls\Model\Repository;
use Rcsvpg\Murls\Model\User\UserEntity;

/**
 * UserController
 * 
 * ユーザー操作関連のURLからの処理を一手に担う
 * UserRepository経由でUserEntity instanceを生成し、
 * ユーザー操作に関する処理を行う
 * 
 * @package Rcsvpg\Murls\Application\Controller
 */
class UserController extends AbstractController
{
    // ConstructorはAbstractControllerにて定義済み
    // ContainerInterfaceを受け取り、
    // logger, PDO, bladeを初期化する
    // Repositoryに隠蔽したのに、PDOって必要なのか？

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->logger->debug(__CLASS__ . ':' . __FUNCTION__);
        $this->logger->info(__CLASS__ . ':' . __FUNCTION__);

        // Make UserRepository
        $this->repository = new Repository(new UserEntity(), $container);
    }

    /**
     * index
     * 
     * ユーザー登録画面を表示する
     * 
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response $response
     */
    public function index(Request $request, Response $response, array $args) : Response
    {
        // UserRepository経由でfindAll()を実行し、
        // UserEntityの配列を取得する
        $users = $this->repository->findAll();

        // users viewにusersを渡して、
        // viewをレンダリングする
        return $this->view($response, 'user.register', ['users' => $users]);
    }

    // rergister
    // ユーザー登録画面を表示する
    // ユーザー登録画面には、
    // email, password, password_confirmationの3つの入力欄がある
    // emailは必須で、passwordは8文字以上である必要がある
    // passwordとpassword_confirmationが一致している必要がある
    public function register(Request $request, Response $response, array $args) : Response
    {
        // make name, email, password available in view
        return $this->view($response, 'user.register', 
            ['email' => '', 'password' => '', 'errors' => [] ]);
    }

    // store data from registration form
    public function registerPost(Request $request, Response $response, array $args) : Response
    {
        // get form data
        $data = $request->getParsedBody();

        // validate form data
        $errors = $this->validate($data);

        // if there is no error
        if ( empty($errors) ) {
            // create user entity
            $user = $this->repository->create($data);

            // save user entity
            $this->repository->save($user);

            // redirect to login page
            $this->logger->info('User registered: ' . $user->email);
            return $response->withHeader('Location', '/login');
        }

        // if there is error
        // return to register page with error message
        return $this->view($response, 'user.register', 
            ['email' => $data['email'], 'password' => '', 'errors' => $errors ]);
    }

    // validate form data
    protected function validate(array $data) : array
    {
        // initialize errors
        $errors = [];

        // check email
        if ( empty($data['email']) ) {
            $errors['email'] = 'Email is required';
        } else if ( !filter_var($data['email'], FILTER_VALIDATE_EMAIL) ) {
            $errors['email'] = 'Email is invalid';
        } else if ( $this->repository->exists('email', $data['email']) ) {
            $errors['email'] = 'Email is already taken';
        }

        // check password
        if ( empty($data['password']) ) {
            $errors['password'] = 'Password is required';
        } else if ( strlen($data['password']) < 8 ) {
            $errors['password'] = 'Password must be at least 8 characters';
        } else if ( $data['password'] !== $data['password_confirmation'] ) {
            $errors['password'] = 'Password does not match';
        }

        // return errors
        return $errors;
    }

    // login
    public function login(Request $request, Response $response, array $args) : Response
    {
        // make email and password available in view
        return $this->view($response, 'user.login', ['email' => '', 'password' => '', 'errors' => [] ]);
    }

    // login post
    public function loginPost(Request $request, Response $response, array $args) : Response
    {
        // get form data
        $data = $request->getParsedBody();

        // validate form data
        $errors = $this->validateLogin($data);

        // if there is no error
        if ( empty($errors) ) {
            // create user entity
            $user = $this->repository->findByEmail($data['email']);

            // save user entity
            $this->repository->save($user);

            // redirect to login page
            return $response->withHeader('Location', '/login');
        }

        // if there is error
        // return to register page with error message
        return $this->view($response, 'user.login', 
            ['email' => $data['email'], 'password' => '', 'errors' => $errors ]);
    }
}
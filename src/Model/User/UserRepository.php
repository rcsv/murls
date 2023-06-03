<?php
declare(strict_types=1);

namespace Rcsvpg\Murls\Model\User;

use Rcsvpg\Murls\Model\RepositoryInterface;
use Rcsvpg\Murls\Model\EntityInterface;
use Psr\Container\ContainerInterface;

class UserRepository implements RepositoryInterface
{
    private $logger;
    private $pdo;

    public function __construct(ContainerInterface $container)
    {
        $this->logger = $container->get('logger');
        $this->pdo = $container->get('pdo');
    }
    
    public function findAll() : ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users');
        $stmt->execute();
        $users = $stmt->fetchAll();
        return $users;
    }

    public function count() : int
    {
        return count($this->findAll());
    }

    public function find(int $id) : ?EntityInterface
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch();
        return new UserEntity($user);
    }

    public function findByTitle(string $title) : ?EntityInterface
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE title = :title');
        $stmt->execute(['title' => $title]);
        $user = $stmt->fetch();
        return new UserEntity($user);
    }

    public function create(EntityInterface $data) : int {

        // TODO:
        // --------------------------------
        // 1. check if exists
        // 2. if not exists make verify url
        // 3. insert into db
        // 4. send email with verify url
        // 5. return id

        // 1. check if exists
        if ( $this->findByTitle($data->getUniqueValue()) ) {
            throw new \Exception('User already exists');
        }

        // 2. if not exists make verify url
        $verify = $this->makeVerifyUrl($data->getUniqueValue());

        $stmt = $this->pdo->prepare('INSERT INTO users (email, password) VALUES (:title, :pass)');
        $stmt->execute([
            'title' => $data->getUniqueValue(),
            'pass' => $data->getSlaveValue(),
        ]);
        return (int) $this->pdo->lastInsertId();
    }

    public function update(EntityInterface $data) : bool {
        $stmt = $this->pdo->prepare('UPDATE users SET email = :title, password = :pass WHERE id = :id');
        $stmt->execute([
            'id' => $data->getId(),
            'title' => $data->getUniqueValue(),
            'pass' => $data->getSlaveValue(),
        ]);
        return true;
    }

    public function delete(int $id) : bool {
        $stmt = $this->pdo->prepare('DELETE FROM users WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return true;
    }

    private function makeVerifyUrl(string $title) : string {
        $verify = md5($title . time());
        $stmt = $this->pdo->prepare('UPDATE users SET verify = :verify WHERE title = :title');
        $stmt->execute([
            'title' => $title,
            'verify' => $verify,
        ]);
        return $verify;
    }
}
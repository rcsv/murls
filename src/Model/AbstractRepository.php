<?php
declare(strict_types=1);
// path: src/Model/AbstractRepository.php
namespace Rcsvpg\Murls\Model;

use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

abstract class AbstractRepository implements RepositoryInterface
{
    protected $container;
    protected $pdo;
    protected $logger;

    // findAll などで使う
    protected string $table_name;

    public function __construct(ContainerInterface $container)
    {
        // object injection
        $this->container = $container;

        // get PDO instance
        $this->pdo = $container->get(\PDO::class);

        // get logger instance
        $this->logger = $container->get(LoggerInterface::class);
    }

    // list all
    public function findAll(): array
    {
        if (!isset($this->table_name)) {
            throw new MurlsNotSetException('table_name is not set');
        }

        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table_name}");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // find by id
    public function findById(int $id): ?array
    {
        if (!isset($this->table_name)) {
            throw new MurlsNotSetException('table_name is not set');
        }

        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table_name} WHERE id = :id");
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch();
        $user = new UserEntity();        
        $user->setSeverals($result);

        // logger
        $this->logger->debug(__CLASS__ . ':' . __FUNCTION__, ['id' => $id, 'user' => $user]);
        $this->logger->debug($result);
        return $stmt->fetch();
        return new UserEntity();$stmt->fetch();
    }

    // counting
    public function count(): int
    {
        if (!isset($this->table_name)) {
            throw new MurlsNotSetException('table_name is not set');
        }

        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM {$this->table_name}");
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    // create
    public function create(array $data): int
    {
        if (!isset($this->table_name)) {
            throw new MurlsNotSetException('table_name is not set');
        }

        $columns = implode(',', array_keys($data));
        $values = implode(',', array_fill(0, count($data), '?'));

        $stmt = $this->pdo->prepare("INSERT INTO {$this->table_name} ({$columns}) VALUES ({$values})");
        $stmt->execute(array_values($data));
        return (int)$this->pdo->lastInsertId();
    }

    // update
    public function update(int $id, array $data): bool
    {
        if (!isset($this->table_name)) {
            throw new \Exception('table_name is not set');
        }

        $columns = implode('=?,', array_keys($data)) . '=?';

        $stmt = $this->pdo->prepare("UPDATE {$this->table_name} SET {$columns} WHERE id = :id");
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        return $stmt->execute(array_values($data));
    }

    // delete
    public function delete(int $id): bool
    {
        if (!isset($this->table_name)) {
            throw new MurlsNotSetException('table_name is not set');
        }

        $stmt = $this->pdo->prepare("DELETE FROM {$this->table_name} WHERE id = :id");
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        return $stmt->execute();
    }
}
<?php
declare(strict_types=1);
// path: src/Model/AbstractRepository.php
namespace Rcsvpg\Murls\Model;

use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

abstract class AbstractRepository implements RepositoryInterface
{
    // setting object injection
    protected $container;

    protected $pdo;
    protected $logger;

    // findAll などで使う
    protected string $table_name;

    // テーブル名は、登録した Entity から取得する
    protected EntityInterface $entity;

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
        check_implemented();

        $stmt = $this->pdo->prepare("SELECT * FROM {$entity->getTableName()}");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // find by id
    public function findById(int $id): EntityInterface
    {
        check_implemented();

        $stmt = $this->pdo->prepare("SELECT * FROM {$entity->getTableName()} WHERE id = :id");
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
    
        // set result into entity
        $entity->setSeverals($stmt->fetch());

    }

    // create
    public function create(array $data): int
    {
        check_implemented();

        // not implemented yet...
        return 0;
    }

    // update
    public function update(int $id, array $data): bool
    {
        check_implemented();

        // not implemented yet...
        return false;
    }

    // delete
    public function delete(int $id): bool
    {
        check_implemented();

        $stmt = $this->pdo->prepare("DELETE FROM {$entity->getTableName()} WHERE id = :id");
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    private function check_implemented(string $error_message = 'table_name is not set')
    {
        if (empty($entity)) {
            throw new MurlsNotSetException('eneity is not set');
        }
        if ($entity->getTableName() == '') {
            throw new MurlsNotSetException($error_message);
        }
    }
}
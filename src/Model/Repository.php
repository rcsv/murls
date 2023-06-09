<?php
declare(strict_types=1);
// path: src/Model/AbstractRepository.php
namespace Rcsvpg\Murls\Model;

use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

/**
 * Repository Concrete Class
 * 
 * RepositoryInterfaceの実装。
 * Do not make Entity-specific Repository like: `SomeRepository` cause
 * Repository is a class that has a common interface for all entities.
 */
class Repository implements RepositoryInterface
{

    /**
     * @var string $table_name テーブル名
     */
    protected string $table_name;

    /**
     * @var EntityInterface $entity EntityInterfaceを実装したクラスのインスタンス
     */
    protected EntityInterface $entity;
    
    /**
     * @var ContainerInterface $container DIコンテナ
     */
    protected ContainerInterface $container;

    /**
     * @var \PDO $pdo PDOインスタンス
     */
    protected \PDO $pdo;

    /**
     * @var LoggerInterface $logger Loggerインスタンス
     */
    protected LoggerInterface $logger;

    /**
     * Construct with DI Container and Entity Type
     */
    public function __construct(EntityInterface $entity, ContainerInterface $container)
    {
        // object injection
        $this->container = $container;

        // get PDO instance
        $this->pdo = $container->get(\PDO::class);

        // get logger instance
        $this->logger = $container->get(LoggerInterface::class);

        // set entity
        $this->entity = $entity;

        // set table name
        $this->table_name = $entity->getTableName();
    }

    /**
     * create
     * Create new Entity
     * 
     * @param array $data
     * @return EntityInterface
     */
    public function create(array $data): EntityInterface
    {
        $entity = clone $this->entity;
        $entity->setSeverals($data);
        $entity->setId(null);
        return $entity;
    }

    /**
     * save
     * Save Entity
     * 
     * @param EntityInterface $entity
     * @return int $id
     */
    public function save(EntityInterface $entity): int
    {
        $id = $entity->getId();
        if (empty($id)) {
            return $this->insert($entity);
        } else {
            return $this->update($entity);
        }
    }

    /**
     * insert
     * Insert new record
     * 
     * @param EntityInterface $entity
     * @return int $id
     */
    public function insert(EntityInterface $entity): int
    {
        $stmt = $this->pdo->prepare("INSERT INTO {$this->table_name} ({$entity->getColumns()}) VALUES ({$entity->getValues()})");
        $stmt->execute($entity->getBindValues());
        return (int)$this->pdo->lastInsertId();
    }

    /**
     * update
     * Update record
     * 
     * @param EntityInterface $entity
     * @return int $id
     */
    public function update(EntityInterface $entity): int
    {
        $stmt = $this->pdo->prepare("UPDATE {$this->table_name} SET {$entity->getSetValues()} WHERE id = :id");
        $stmt->bindValue(':id', $entity->getId(), \PDO::PARAM_INT);
        $stmt->execute($entity->getBindValues());
        return (int)$entity->getId();
    }

    /**
     * delete
     * Delete record
     * 
     * @param EntityInterface $entity
     * @return bool
     */
    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table_name} WHERE id = :id");
        $stmt->bindValue(':id', $id(), \PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * findAll
     * Get all records
     * 
     * @return array
     */
    public function findAll(): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table_name}");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * findById
     * Find record by id
     * 
     * @param int $id
     * @return EntityInterface
     */
    public function findById(int $id): EntityInterface
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table_name} WHERE id = :id");
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $entity = clone $this->entity;
        $entity->setSeverals($stmt->fetch());
        return $entity;
    }

    /**
     * findBy
     * Find record by column name
     * 
     * @param string $column
     * @param mixed $value
     * @return EntityInterface[]
     */
    public function findBy(string $column, $value): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table_name} WHERE {$column} = :{$column}");
        $stmt->bindValue(":{$column}", $value);
        $stmt->execute();
        $entity = clone $this->entity;
        $entity->setSeverals($stmt->fetch());
        return $entity;
    }
    /*

    

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
    */


}
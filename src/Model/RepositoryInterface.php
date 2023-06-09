<?php
declare(strict_types=1);

namespace Rcsvpg\Murls\Model;

/**
 * RepositoryInterface
 * 
 * RepositoryInterface と EntityInterface は、
 * データベースへ登録する操作と、データベースから取得する情報を表現したもの。
 * 
 */
interface RepositoryInterface
{
    /**
     * findAll
     * EntityInterface[] を返す
     * @return EntityInterface[]
     */
    public function findAll() : array;

    /**
     * findBy
     * EntityInterface[] を返す。WHERE user_id = 1 などの条件を指定する
     * @param  string $column
     * @param  string $value
     * @return EntityInterface[]
     */
    public function findBy(string $column, string $value) : array;

    /**
     * create
     * Userの場合はregisterのように情報を受け取り、DBに保存、UserEntityを返す
     * @param  EntityInterface $entity
     * @return int
     */
    public function create(array $data): EntityInterface;

    /**
     * save
     * Userの場合はidを受け取り、DBに保存、UserEntityを返す
     * @param  EntityInterface $entity
     * @return int
     */
    public function save(EntityInterface $entity): int;
    
    /**
     * read
     * Userの場合はidを受け取り、DBから情報を取得、UserEntityを返す
     * @param  int $id
     * @return EntityInterface
     */
    public function findById(int $id): EntityInterface;

    /**
     * update
     * Userの場合はidと情報を受け取り、DBを更新、UserEntityを返す
     * @param  EntityInterface $entity
     * @return bool
     */
    public function update(EntityInterface $entity): int;

    /**
     * delete
     * Userの場合はidを受け取り、DBから削除、boolを返す
     * @param  int $id
     * @return bool
     */
    public function delete(int $id): bool;

}
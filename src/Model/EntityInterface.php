<?php
/**
 * EntityInterface.php : EntityInterface
 * CRUDの処理は Repository に記述し、データセットの考え方から切り離す。
 * Entityはデータの保持と、Repository に対してデータを渡す役割を持つ。
 * 各テーブル毎に、このインターフェースを実装したクラスを作成する。
 * (Repositoryは単一で、Entityは複数作成)
 * 
 * @package Rcsvpg\Murls\Model
 * @since 2023/05/31
 * @version 1.0.0
 */
declare(strict_types=1);

namespace Rcsvpg\Murls\Model;

/**
 * EntityInterface
 * 
 */
interface EntityInterface extends \JsonSerializable
{
    /**
     * getTableName
     * 
     * Returns the target table name of the `EntityInterface`. It is used
     * by the `Repository` implemented interface: `RepositoryInterface` to
     * switch tables for each Entity.
     * Return value like: `users`, `posts`, `comments` etc., can use as
     * sql statement like: `SELECT * FROM $this->getTableName()`.
     * 
     * @return string Entityが対象とするテーブル名
     */
    public function getTableName(): string;

    /**
     * getColumns
     * 
     * Returns the target table columns of the `EntityInterface`. It is used
     * by the `Repository` implemented interface: `RepositoryInterface` to
     * switch tables for each Entity.
     * Return value like: `['id', 'name', 'email']` etc., can use as
     * sql statement like: `SELECT $this->getColumns() FROM $this->getTableName()`.
     * 
     * @return array Entityが持つカラム名の配列
     */
    public function getColumns(): array;

    /**
     * getValues
     * 
     * Returns the target table values of the `EntityInterface`. It is used
     * by the `Repository` implemented interface: `RepositoryInterface` to
     * switch tables for each Entity.
     * Return value like: `[1, 'John Doe'...]` etc., can use as
     * sql statement like: `INSERT INTO $this->getTableName() ($this->getColumns()) VALUES ($this->getValues())`.
     * 
     * @return array Entityが持つ値の配列
     */
    public function getValues(): array;

    /**
     * getId
     * get Primary Key
     * @return int|null
     */
    public function getId(): ?int;

    /**
     * getUnique
     * User なら email, Url なら shortcode、など、それぞれのテーブルのユニークな値を返す
     * @return string|null
     * @throws MurlsNotSetException
     */
    public function getUnique(): string ;

    /**
     * getSecondaryValue
     * User なら name, Url なら longurl、など、それぞれのテーブルのユニークでない従属的な値を返す
     * @return string|null
     * @throws MurlsNotSetException
     */
    public function getSecondary(): string;

    /**
     * setSeverals
     * @param array $data
     * @return void
     */
    public function setSeverals(array $data): void;

    /**
     * getBindValues
     * @return array
     * @throws MurlsNotSetException
     */
    public function getBindValues(): array;

    /**
     * getSetValues
     * @return array
     * @throws MurlsNotSetException
     */
    public function getSetValues(): array;
}
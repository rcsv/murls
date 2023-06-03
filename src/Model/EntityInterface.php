<?php
declare(strict_types=1);
// path: src/Model/EntityInterface.php

namespace Rcsvpg\Murls\Model;

// RepositoryInterface と EntityInterface は、
// それぞれのクラスで実装する必要がある。
interface EntityInterface extends \JsonSerializable
{
    /**
     * getTableName
     */
    public function getTableName(): string;

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
    //throws MurlsNotSetException

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

    // TODO: make phrase for sql query
}
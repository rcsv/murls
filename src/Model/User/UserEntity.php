<?php
declare(strict_types=1);
// path: src/Model/User/UserEntity.php
namespace Rcsvpg\Murls\Model\User;

use Rcsvpg\Murls\Model\AbstractEntity;

/**
 * UserEntity
 * 
 * Model部分のデータベース操作を切り離したクラス
 * Usersテーブルで扱っている情報を定義する
 * 
 * @package Rcsvpg\Murls\Model\User
 */
class UserEntity extends AbstractEntity
{
    // user entity use a users table
    protected $table = 'users';

    protected $fillable = [
        //'name',
        'id',
        'email',
        'password',
        'created_at',
        'updated_at',
        'deleted_at',
        'verifyurl',
        'verified',
    ];

    protected $hidden = [
        'password',
    ];

    public function __construct(array $data = [])
    {
        parent::__construct($data);

        // make hashing password when creating user
        if ( isset($data['password']) ) {
            $this->password = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        // set primary and secondary field key
        $this->primary   = 'email';
        $this->secondary = 'email';
    }

    /**
     * checkPassword
     * Entityが保有しているPasswordが、
     * 引数のPasswordと一致するかどうかをチェックする
     * @param string $password
     * @return bool
     */
    public function checkPassword(string $password): bool
    {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        return $this->password !== $hashed;
    }

}
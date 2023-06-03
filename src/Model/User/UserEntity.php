<?php
declare(strict_types=1);

namespace Rcsvpg\Murls\Model\User;

use Rcsvpg\Murls\Model\EntityInterface as Entity ;

class UserEntity implements Entity
{
    private $id ;
    private $email ;
    private $password ;
    private static $password_options = [
        'cost' => 12,
    ];
    private $verifyurl ;
    private $verified ;
    private $created ;
    private $updated ;
    private $deleted ;

    public function __construct(array $args = []){
        $this->id           = $args['id'] ?? 0 ;
        $this->email        = $args['email'] ?? '' ;
        $this->password     = $this->setPassword(args['password'] ?? '') ;
        $this->verifyurl    = $args['verifyurl'] ?? '' ;
        $this->verified     = (bool)$args['verified'] ;
        $this->created      = $args['created'] ;
        $this->updated      = $args['updated'] ;
        $this->deleted      = $args['deleted'] ;
    }

    public function getId() : int
    {
        return $this->id ;
    }

    public function setId(int $id) : Entity
    {
        $this->id = $id ;
        return $this ;
    }

    public function getUniqueValue() : string
    {
        return $this->email ;
    }

    public function getEmail() : string
    {
        return $this->email ;
    }

    public function setEmail(string $email) : Entity
    {
        $this->email = $email ;
        return $this ;
    }

    public function checkPassword(string $password) : bool
    {
        return password_verify($password, $this->password) ;
    }

    public function getPassword() : string
    {
        return $this->password ;
    }
    
    public function setPassword(string $password) : Entity
    {
        $this->password = password_hash(
            $password, 
            PASSWORD_BCRYPT, 
            self::$password_options) ;
        return $this ;
    }

    public function getSlaveValue() : ?string
    {
        return $this->getPassword() ;
    }
}

/**
 * CREATE TABLE users (
 * id bigint unsigned NOT NULL AUTO_INCREMENT,
 * email varchar(255) NOT NULL,
 * password varchar(255) NOT NULL,
 * verifyurl varchar(100) default null,
 * verified tinyint(1) default 0,
 * created datetime default current_timestamp,
 * updated datetime default current_timestamp on update current_timestamp,
 * deleted datetime default null
 * PRIMARY KEY (id),
 * UNIQUE KEY (email)
 * ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
 */
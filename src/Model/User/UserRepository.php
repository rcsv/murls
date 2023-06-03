<?php
declare(strict_types=1);
// path: src/Model/User/UserRepository.php
namespace Rcsvpg\Murls\Model\User;

use Rcsvpg\Murls\Model\RepositoryInterface;
use Rcsvpg\Murls\Model\AbstractRepository;
use Rcsvpg\Murls\Model\EntityInterface;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

/**
 * Class UserRepository
 * 
 * UserEntity を操作するクラス
 * @package Rcsvpg\Murls\Model\User
 * @implements RepositoryInterface
 */
class UserRepository extends AbstractRepository
{
    public function __constract(ContainerInterface $container)
    {
        parent::__constract($container);

        // set table name
        $this->table = 'users';
    }
}
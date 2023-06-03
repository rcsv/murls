<?php
declare(strict_types=1);

namespace Rcsvpg\Murls\Model;

interface RepositoryInterface
{
    function findAll() : ?array;

    function find(int $id) : ?EntityInterface;

    function findByTitle(string $title) : ?EntityInterface;

    function create(EntityInterface $data) : int;

    function update(EntityInterface $data) : bool;

    function delete(int $id) : bool;

    function count() : int;
}
<?php

namespace Rcsvpg\Murls\Model;

interface RepositoryInterface
{
    function findAll() : ?array;

    function find(int $id) : ?EntityInterface;

    function findByTitle(string $title) : ?EntityInterface;

    function insert(EntityInterface $data) : int;

    function update(EntityInterface $data) : bool;

    function delete(int $id) : bool;

    function count() : int;
}
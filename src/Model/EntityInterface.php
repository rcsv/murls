<?php

namespace Rcsvpg\Murls\Model;

interface EntityInterface extends \JsonSerializable
{
    //
    public function getId(): ?int;
    public function setId(int $id): void;
    public function getUniqueValue(): ?string;
    public function getSlaveValue(): ?string;
}
<?php
declare(strict_types=1);
// path: src/Model/AbstractEntity.php
namespace Rcsvpg\Murls\Model;

use Psr\Container\ContainerInterface;

/**
 * Abstract Entity
 */
abstract class AbstractEntity implements EntityInterface
{
    // instance has a table name
    protected string $table;

    // fillable columns in the table
    protected $fillable = [];

    // hidden
    protected $hidden = [];

    // set primary unique field
    protected string $unique; // default is id

    // set secondary unique field
    protected string $title; // default is email

    // ContainerInterface
    protected ContainerInterface $container;

    // array
    protected array $data;

    // __construct
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    // __setter
    public function __set($name, $value)
    {
        // if fillable
        if ( in_array($name, $this->fillable) ) {
            $this->data[$name] = $value;
        }
    }

    // __getter
    public function __get($name)
    {
        // if hidden
        if ( in_array($name, $this->hidden) ) {
            return null;
        }
        return $this->data[$name];
    }

    // setSeverals
    public function setSeverals(array $data): void
    {
        foreach ($data as $key => $value) {
            $this->data[$key] = $value;
        }
    }

    public function jsonSerialize()
    {
        // return array without hidden data
        $data = [];
        foreach ($this->data as $key => $value) {
            if ( !in_array($key, $this->hidden) ) {
                $data[$key] = $value;
            }
        }
        return $data;
    }

    public function __toString()
    {
        return $this->data();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    // getUniqueValue
    public function getUnique(): string
    {
        if ( $this->unique ) {
            return $this->{$this->unique};
        }
        throw new MurlsNotSetException();
    }

    // getSeondary
    public function getSecondary(): string
    {
        if ( $this->title ) {
            return $this->{$this->title};
        }
        throw new MurlsNotSetException();
    }
}
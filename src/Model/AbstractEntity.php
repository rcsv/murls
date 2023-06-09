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

    public function jsonSerialize(): mixed
    {
        // return array without hidden data
        $data = [];
        foreach ($this->data as $key => $value) {
            if ( !in_array($key, $this->hidden) ) {
                $data[$key] = $value;
            }
        }
        return json_encode($data);
    }

    public function __toString()
    {
        return $this->data();
    }

    // getTable
    public function getTableName(): string
    {
        if ( $this->table ) {
            return $this->table;
        }
        throw new MurlsNotSetException('Table name is not set.');
    }

    // getId
    public function getId(): ?int
    {
        if( $this->id ) {
            return $this->id;
        }
        throw new MurlsNotSetException('Primary key is not set.');
    }

    // getUniqueValue
    public function getUnique(): string
    {
        if ( $this->unique ) {
            return $this->unique;
        }
        throw new MurlsNotSetException('Unique field is not set.');
    }

    // getSeondary
    public function getSecondary(): string
    {
        if ( $this->title ) {
            return $this->title;
        }
        throw new MurlsNotSetException('Secondary field is not set.');
    }

    // getColumns
    public function getColumns(): array
    {
        return $this->fillable;
    }

    // getValues
    public function getValues(): array
    {
        $values = [];
        foreach ($this->fillable as $column) {
            $values[] = $this->data[$column];
        }
        return $values;
    }

    // getBindValues
    public function getBindValues(): array
    {
        $values = [];
        foreach ($this->fillable as $column) {
            $values[':' . $column] = $this->data[$column];
        }
        return $values;
    }

    // getSetValues
    public function getSetValues(): array
    {
        $values = [];
        foreach ($this->fillable as $column) {

            // when $data[$column] is null, skip
            if ( is_null($this->data[$column]) ) {
                continue;
            }

            $values[] = $column . ' = :' . $column;
        }
        return $values;
    }
}
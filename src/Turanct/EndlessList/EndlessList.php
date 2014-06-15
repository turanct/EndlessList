<?php

namespace Turanct\EndlessList;

use Iterator;
use Closure;

abstract class EndlessList implements Iterator
{
    /**
     * @var Closure The closure used to calculate the next element of the list
     */
    protected $getNext;

    /**
     * @var Closure The closure that defines a mapper function for the list
     */
    protected $map;

    /**
     * @var int The current key (for iterator)
     */
    protected $currentKey;

    /**
     * @var mixed The current value (for iterator)
     */
    protected $currentValue;

    /**
     * @var mixed The current value, mapped (for iterator)
     */
    protected $currentValueMapped;

    /**
     * Factory method
     *
     * @param mixed   $start   The starting key/value (depending on implementation)
     * @param Closure $getNext The closure used to calculate the next element of the list
     *
     * @return EndlessList A new endless list
     */
    abstract public static function create($start, Closure $getNext);

    /**
     * Apply a mapper on this list
     *
     * @param Closure $map The closure that defines a mapper function for the list
     *
     * @return EndlessList A new endless list
     */
    public function map(Closure $map)
    {
        if ($this->map === null) {
            $newMap = $map;
        } else {
            $oldMap = $this->map;
            $newMap = function ($a) use ($oldMap, $map) {
                $b = $oldMap($a);
                $c = $map($b);

                return $c;
            };
        }

        return new static($this->start, $this->getNext, $newMap);
    }

    /**
     * Get the mapped value, for a given value
     *
     * @param mixed $value The value we want to get a mapped version for, from the mapper
     *
     * @return mixed The mapped value
     */
    protected function getMappedValue($value)
    {
        if ($this->map !== null) {
           $map = $this->map;

           return $map($value);
        }

        return $value;
    }

    /**
     * Get an array of values, with a limit and an offset
     *
     * @param int $limit  The limit
     * @param int $offset The offset
     *
     * @return array An array of values
     */
    abstract public function getArray($limit, $offset = 0);

    /**
     * Current method (for iterator)
     *
     * @return mixed The current value (mapper applied)
     */
    public function current()
    {
        return $this->currentValueMapped;
    }

    /**
     * Key method (for iterator)
     *
     * @return int The current key
     */
    public function key()
    {
        return $this->currentKey;
    }

    /**
     * Go to the next value (for iterator)
     */
    abstract public function next();

    /**
     * Rewind method (for iterator)
     */
    abstract public function rewind();

    /**
     * Valid method (for iterator)
     */
    public function valid()
    {
        return true;
    }
}

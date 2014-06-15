<?php

namespace Turanct\EndlessList;

use Closure;

class EndlessListPosition extends EndlessList
{
    /**
     * @var mixed The starting key
     */
    protected $start;

    /**
     * Constructor
     *
     * @param mixed   $start   The starting key
     * @param Closure $getNext The closure used to calculate the next element of the list
     * @param Closure $map     The closure that defines a mapper function for the list
     */
    protected function __construct($start, Closure $getNext, Closure $map)
    {
        $this->start = (int) $start;
        $this->getNext = $getNext;
        $this->map = $map;

        $this->currentKey = (int) $start;
        $this->currentValue = $this->getValue($this->currentKey);
        $this->currentValueMapped = $this->getMappedValue($this->currentValue);
    }

    /**
     * Factory method
     *
     * @param mixed   $start   The starting key
     * @param Closure $getNext The closure used to calculate the next element of the list
     *
     * @return EndlessList A new endless list
     */
    public static function create($start, Closure $getNext)
    {
        return new static($start, $getNext, function ($a) {return $a;});
    }

    /**
     * Get a value, based on key
     *
     * @param mixed $key The key for calculating a new value
     *
     * @return mixed The next value
     */
    protected function getValue($key)
    {
        $getNext = $this->getNext;

        $nextValue = $getNext((int) $key);

        return $nextValue;
    }

    /**
     * Get an array of values, with a limit and an offset
     *
     * @param int $limit  The limit
     * @param int $offset The offset
     *
     * @return array An array of values
     */
    public function getArray($limit, $offset = 0)
    {
        $limit = (int) $limit;
        $offset = ($offset > 0) ? (int) $offset : 0;

        $list = array();

        for ($i = 0; $i < $limit + $offset; $i++) {
                $list[] = $this->getValue($i + $this->start);
        }

        if ($offset > 0) {
            $list = array_slice($list, $offset, $limit);
        }

        if ($this->map !== null) {
            $map = $this->map;

            $list = array_map($map, $list);
        }

        return $list;
    }

    /**
     * Go to the next value (for iterator)
     */
    public function next()
    {
        $this->currentKey++;
        $this->currentValue = $this->getValue($this->currentKey);
        $this->currentValueMapped = $this->getMappedValue($this->currentValue);
    }

    /**
     * Rewind method (for iterator)
     */
    public function rewind()
    {
        $this->currentKey = $this->start;
        $this->currentValue = $this->getValue($this->currentKey);
        $this->currentValueMapped = $this->getMappedValue($this->currentValue);
    }
}
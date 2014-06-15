<?php

namespace Turanct\EndlessList;

use Closure;

class EndlessListSeries extends EndlessList
{
    /**
     * @var mixed The starting value
     */
    protected $start;

    /**
     * Constructor
     *
     * @param mixed   $start   The starting value
     * @param Closure $getNext The closure used to calculate the next element of the list
     * @param Closure $map     The closure that defines a mapper function for the list
     */
    protected function __construct($start, Closure $getNext, Closure $map)
    {
        $this->start = $start;
        $this->getNext = $getNext;
        $this->map = $map;

        $this->currentValue = $start;
        $this->currentValueMapped = $this->getMappedValue($start);
    }

    /**
     * Factory method
     *
     * @param mixed   $start   The starting value
     * @param Closure $getNext The closure used to calculate the next element of the list
     *
     * @return EndlessList A new endless list
     */
    public static function create($start, Closure $getNext)
    {
        return new static($start, $getNext, function ($a) {return $a;});
    }

    /**
     * Get the next value, based on last value
     *
     * @param mixed $lastValue The last value we calculated
     *
     * @return mixed The next value
     */
    protected function getNextValue($lastValue)
    {
        $getNext = $this->getNext;

        $nextValue = $getNext($lastValue);

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
            if ($i == 0) {
                $list[] = $this->start;
            } else {
                $last = end($list);
                $list[] = $this->getNextValue($last);
            }
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
        $this->currentValue = $this->getNextValue($this->currentValue);
        $this->currentValueMapped = $this->getMappedValue($this->currentValue);
    }

    /**
     * Rewind method (for iterator)
     */
    public function rewind()
    {
        $this->currentKey = 0;
        $this->currentValue = $this->start;
        $this->currentValueMapped = $this->getMappedValue($this->start);
    }
}
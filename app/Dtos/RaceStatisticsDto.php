<?php


namespace App\Dtos;


class RaceStatisticsDto
{
    /**
     * @var array
     */
    private $coveredDistances = [];

    /**
     * @var array
     */
    private $positions = [];

    /**
     * @var integer
     */
    private $timestamp;

    public function __construct($timestamp, $coveredDistances, $positions)
    {
        $this->timestamp = $timestamp;
        $this->coveredDistances = $coveredDistances;
        $this->positions = $positions;
    }

    /**
     * @return array
     */
    public function getCoveredDistances(): array
    {
        return $this->coveredDistances;
    }

    /**
     * @return array
     */
    public function getPositions(): array
    {
        return $this->positions;
    }

    /**
     * @return integer
     */
    public function getTimestamp(): int
    {
        return $this->timestamp;
    }
}

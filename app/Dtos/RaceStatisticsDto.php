<?php


namespace App\Dtos;


use App\Race;

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

    /**
     * @var Race $race
     */
    private $race;

    public function __construct(Race $race, $timestamp, array $coveredDistances, array $positions)
    {
        $this->race = $race;
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

    /**
     * @return Race
     */
    public function getRace(): Race
    {
        return $this->race;
    }

}

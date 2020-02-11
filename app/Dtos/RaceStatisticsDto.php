<?php


namespace App\Dtos;


use App\Horse;
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

    /**
     * array of horses indexed by their ids
     * @var Horse[]
     */
    private $horsesById = [];

    public function __construct(Race $race, $timestamp, array $coveredDistances, array $positions, array $horsesById)
    {
        $this->race = $race;
        $this->timestamp = $timestamp;
        $this->coveredDistances = $coveredDistances;
        $this->positions = $positions;
        $this->horsesById = $horsesById;
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

    /**
     * @return Horse[]
     */
    public function getHorsesById(): array
    {
        return $this->horsesById;
    }

}

<?php


namespace App\Services;

use App\Game;
use App\Horse;

/**
 * Encapsulates a logic of horses calculations
 * Class HorseService
 * @package App\Services
 */
class HorseService
{
    /**
     * @var Horse
     */
    private $horse;

    public function __construct(Horse $horse)
    {
        $this->horse = $horse;
    }

    /**
     * returns a number of seconds required for the horse to finish a race
     * @return float
     */
    public function getTimeToFinish(): float
    {
        $distanceOnBestSpeed = $this->getDistanceOnBestSpeed();
        $bestSpeed = $this->getBestSpeed();
        $speedReduce = $this->getSpeedReduce();

        return (Game::RACE_DISTANCE - $distanceOnBestSpeed) / ($bestSpeed - $speedReduce) + $distanceOnBestSpeed / $bestSpeed;
    }

    /**
     * returns a distance (m) covered by the horse at given number of second from a race start
     * @param int $secondsFromRaceStart
     * @return int
     */
    public function getCoveredDistance($secondsFromRaceStart): int
    {
        $distanceOnBestSpeed = $this->getDistanceOnBestSpeed();
        $timeOnBestSpeed = $distanceOnBestSpeed / $this->getBestSpeed();

        if ($secondsFromRaceStart <= $timeOnBestSpeed) {
            $distanceCovered = $secondsFromRaceStart * $this->getBestSpeed();
        } else {
            $distanceCovered = $distanceOnBestSpeed + ($secondsFromRaceStart - $timeOnBestSpeed) * ($this->getBestSpeed() - $this->getSpeedReduce());
        }

        return ($distanceCovered <= Game::RACE_DISTANCE) ? $distanceCovered : Game::RACE_DISTANCE;
    }

    /**
     * @return int
     */
    public function getPostitionInRace(): int
    {

    }

    /**
     * @return int
     */
    protected function getBestSpeed(): int
    {
        return $this->horse->speed + Horse::BASE_SPEED;
    }

    /**
     * Returns how many m/s of speed will be reduced after endurance
     * @return float
     */
    protected function getSpeedReduce(): float
    {
        return Horse::BASE_SPEED_REDUCE_BY_JOKEY - Horse::BASE_SPEED_REDUCE_BY_JOKEY * ($this->horse->strength * Horse::STRENGTH_COEFFICIENT / 100);
    }

    /**
     * Returns a distance that horse can cover on the best speed
     * @return float
     */
    protected function getDistanceOnBestSpeed()
    {
        return 100 * $this->horse->endurance;
    }
}

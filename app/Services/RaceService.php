<?php

namespace App\Services;

use App\Dtos\RaceStatisticsDto;
use App\Game;
use App\Horse;
use App\Race;

class RaceService
{
    /**
     * @var Race
     */
    private $race;

    /**
     * RaceService constructor.
     * @param Race $race
     */
    public function __construct(Race $race)
    {
        $this->race = $race;
    }

    /**
     * @param integer $timestamp
     * @return RaceStatisticsDto
     * @throws \Exception
     */
    public function calculateCurrentRaceStatus($timestamp): RaceStatisticsDto
    {
        $durationOfRace = $timestamp - (new \DateTime($this->race->start_ts))->getTimestamp();
        if ($durationOfRace < 0) {
            throw new \Exception('incorrect timestamp: the race started in future?');
        }

        $horsesCoveredDistance = [];
        $numberOfHorsesFinished = 0;

        foreach ($this->race->horses as $horse) {
            $horseService = new HorseService($horse);
            $horsesCoveredDistance[$horse->id] = $horseService->getCoveredDistance($durationOfRace);
            if ($horsesCoveredDistance[$horse->id] == Game::RACE_DISTANCE) {
                $numberOfHorsesFinished++;
            }
        }

        $horsesPositions = $this->getHorsesPositions($timestamp);

        if ($numberOfHorsesFinished == sizeof($this->race->horses)) {
            $this->race->markAsComplete();
        }

        return new RaceStatisticsDto($this->race, $timestamp, $horsesCoveredDistance, $horsesPositions);
    }

    /**
     * returns an array of horses indexed by their positions (starts from index zero)
     * @param $timestamp
     * @return Horse[]
     * @throws \Exception
     */
    protected function getHorsesPositions($timestamp): array
    {
        $horsesPositions = [];

        $horsesFinished = []; // we will compare them by time to finish
        $horsesNotFinished = []; // we will compare them by covered distance

        $durationOfRace = $timestamp - (new \DateTime($this->race->start_ts))->getTimestamp();

        foreach ($this->race->horses as $horse) {
            $horseService = new HorseService($horse);
            $horseTimeToFinish = $horseService->getTimeToFinish();
            $horseDistance = $horseService->getCoveredDistance($durationOfRace);

            if ($horseTimeToFinish <= $durationOfRace) {
                $horsesFinished[$horse->id] = $horseTimeToFinish;
            } else {
                $horsesNotFinished[$horse->id] = $horseDistance;
            }
        }

        asort($horsesFinished);
        asort($horsesNotFinished);

        foreach ($horsesFinished as $horseId => $finishedHorse) {
            $horsesPositions[] = $horseId;
        }
        foreach ($horsesNotFinished as $horseId => $notFinishedHorse) {
            $horsesPositions[] = $horseId;
        }

        return $horsesPositions;
    }
}

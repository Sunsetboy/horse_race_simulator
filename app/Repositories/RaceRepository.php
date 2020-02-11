<?php


namespace App\Repositories;

use App\Race;
use App\Services\RaceService;

/**
 * Contains working with DB data about races
 *
 * Class RaceRepository
 * @package App\Repositories
 */
class RaceRepository
{
    /**
     * @param integer $currentTimeStamp
     * @return array
     * @throws \Exception
     */
    public function getCurrentRacesStatistics($currentTimeStamp): array
    {
        $currentRacesStats = [];
        $currentRaces = Race::where('status', Race::STATUS_IN_PROGRESS)->get();
        foreach ($currentRaces as $raceNumber => $currentRace) {
            $currentRacesStats[$raceNumber] = (new RaceService($currentRace))->calculateCurrentRaceStatus($currentTimeStamp);
        }

        return $currentRacesStats;
    }

    /**
     * @param integer $currentTimeStamp
     * @return array
     * @throws \Exception
     */
    public function getLastRacesStatistics($currentTimeStamp): array
    {
        $lastCompletedRacesStats = [];
        $lastThreeCompletedRaces = Race::where('status', Race::STATUS_COMPLETE)
            ->orderBy('id', 'desc')
            ->get();
        foreach ($lastThreeCompletedRaces as $raceNumber => $completedRace) {
            $lastCompletedRacesStats[$raceNumber] = (new RaceService($completedRace))->calculateCurrentRaceStatus($currentTimeStamp);
        }

        return $lastCompletedRacesStats;
    }
}

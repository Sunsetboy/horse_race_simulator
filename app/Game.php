<?php

namespace App;

use App\Factories\RaceFactory;

class Game
{
    const RACES_LIMIT = 3;

    private $races = [];

    public function __construct()
    {
        $races = Race::all();

        $this->races = $races;
    }

    /**
     * Creates new races and starts them
     */
    public function createRaces()
    {
        $raceFactory = new RaceFactory();

        for ($i = 0; $i < self::RACES_LIMIT - $this->getNumberOfCurrentRaces(); $i++) {
            $this->races[] = $raceFactory->create();
        }
    }

    protected function getNumberOfCurrentRaces(): int
    {
        $currentRacesNumber = 0;

        foreach ($this->races as $race) {
            if ($race->status == Race::STATUS_IN_PROGRESS) {
                $currentRacesNumber++;
            }
        }

        return $currentRacesNumber;
    }
}

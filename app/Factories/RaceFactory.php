<?php


namespace App\Factories;

use App\Race;

class RaceFactory
{
    /**
     * Creates a Race with horses
     */
    public function create(): Race
    {
        $race = new Race();
        $race->status = Race::STATUS_IN_PROGRESS;
        $race->start_ts = time();
        $race->save();

        $horseFactory = new HorseFactory();

        for ($i = 0; $i < Race::NUMBER_OF_HORSES; $i++) {
            $horse = $horseFactory->create();
            try {
                $race->addHorse($horse);
            } catch (\Exception $exception) {
                break;
            }

            $horse->save();
        }

        return $race;
    }
}

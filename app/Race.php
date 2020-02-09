<?php

namespace App;

use App\Services\HorseService;
use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
    const NUMBER_OF_HORSES = 8; // race capacity
    const STATUS_IN_PROGRESS = 'PROGRESS';
    const STATUS_COMPLETE = 'COMPLETE';

    protected $table = 'races';
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function horses()
    {
        return $this->hasMany('App\Horse');
    }

    /**
     * @param Horse $horse
     * @throws \Exception
     */
    public function addHorse(Horse $horse)
    {
        if (sizeof($this->horses) < self::NUMBER_OF_HORSES) {
            $horse->race_id = $this->id;
            $horse->save();
        } else {
            throw new \Exception('Limit for horses in one race is reached');
        }
    }

    /**
     * sets race status as COMPLETE, saves each horse finish time
     */
    public function markAsComplete()
    {
        if ($this->status == self::STATUS_COMPLETE) {
            // already completed
            return;
        }

        $this->status = self::STATUS_COMPLETE;
        $this->save();

        foreach ($this->horses as $horse) {
            // lets save each horse finish time for getting statistics later
            $horseService = new HorseService($horse);
            $finishTime = $horseService->getTimeToFinish();
            $horse->saveFinishTime($finishTime);
        }
    }

}

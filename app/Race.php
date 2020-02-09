<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
    const NUMBER_OF_HORSES = 8; // race capacity
    const STATUS_IN_PROGRESS = 'PROGRESS';
    const STATUS_COMPLETE = 'COMPLETE';

    protected $table = 'race';
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
        } else {
            throw new \Exception('Limit for horses in one race is reached');
        }
    }

}

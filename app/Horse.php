<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Horse extends Model
{
    protected $table = 'horse';
    public $timestamps = false;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->strength = mt_rand(0, 100) / 10;
        $this->speed = mt_rand(0, 100) / 10;
        $this->endurance = mt_rand(0, 100) / 10;
    }
}

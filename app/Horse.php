<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Horse extends Model
{
    protected $table = 'horses';
    public $timestamps = false;

    const BASE_SPEED = 5;
    const BASE_SPEED_REDUCE_BY_JOKEY = 5;
    const STRENGTH_COEFFICIENT = 8;
}

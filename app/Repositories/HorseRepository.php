<?php


namespace App\Repositories;

use App\Horse;

class HorseRepository
{
    public function getBestHorseEver(): Horse
    {
        return Horse::where('finish_time', '>', 0)->orderBy('finish_time', 'asc')->first();
    }
}

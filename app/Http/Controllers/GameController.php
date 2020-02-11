<?php

namespace App\Http\Controllers;

use App\Game;
use App\Helpers\FakeTime;
use App\Horse;
use App\Race;
use App\Services\RaceService;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
    {
        $currentTimeStamp = FakeTime::getInstance()->get();

        // get current races
        $currentRacesStats = [];
        $currentRaces = Race::where('status', Race::STATUS_IN_PROGRESS)->get();
        foreach ($currentRaces as $raceNumber => $currentRace) {
            $currentRacesStats[$raceNumber] = (new RaceService($currentRace))->calculateCurrentRaceStatus($currentTimeStamp);
        }

        dd($currentRacesStats);
        // get last 5 races results
        $lastCompletedRacesStats = [];
        $lastThreeCompletedRaces = Race::where('status', Race::STATUS_COMPLETE)
            ->orderBy('id', 'desc')
            ->get();
        foreach ($lastThreeCompletedRaces as $raceNumber => $completedRace) {
            $lastCompletedRacesStats[$raceNumber] = (new RaceService($completedRace))->calculateCurrentRaceStatus($currentTimeStamp);
        }

//        dd($lastCompletedRacesStats);

        // get the best ever time

        $bestHorseEver = Horse::where('finish_time', 'is not null')->orderBy('finish_time', 'asc')->first();
//        dd($bestHorseEver);

        $currentDateTime = FakeTime::getInstance()->getDateTime()->format('Y-m-d H:i:s');

        return view('index', [
            'currentRacesStats' => $currentRacesStats,
            'lastCompletedRacesStats' => $lastCompletedRacesStats,
            'bestHorseEver' => $bestHorseEver,
            'currentDateTime' => $currentDateTime,
        ]);
    }

    public function create()
    {
        $game = new Game();
        $game->createRaces(1);

        return redirect('/');
    }

    public function progress()
    {
        FakeTime::getInstance()->increment(10);

        return redirect('/');
    }
}

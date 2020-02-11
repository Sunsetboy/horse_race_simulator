<?php

namespace App\Http\Controllers;

use App\Game;
use App\Helpers\FakeTime;
use App\Horse;
use App\Race;
use App\Repositories\HorseRepository;
use App\Repositories\RaceRepository;
use App\Services\RaceService;

class GameController extends Controller
{
    /**
     * Displays statistics page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function index()
    {
        $currentTimeStamp = FakeTime::getInstance()->get();
        $currentDateTime = FakeTime::getInstance()->getDateTime()->format('Y-m-d H:i:s');

        $raceRepository = new RaceRepository();
        $horseRepository= new HorseRepository();

        // get current races
        $currentRacesStats = $raceRepository->getCurrentRacesStatistics($currentTimeStamp);

        // get last 5 races results
        $lastCompletedRacesStats = $raceRepository->getLastRacesStatistics($currentTimeStamp);

        // get the best ever time
        $bestHorseEver = $horseRepository->getBestHorseEver();

        return view('index', [
            'currentRacesStats' => $currentRacesStats,
            'lastCompletedRacesStats' => $lastCompletedRacesStats,
            'bestHorseEver' => $bestHorseEver,
            'currentDateTime' => $currentDateTime,
        ]);
    }

    /**
     * Creates a new race
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function create()
    {
        $game = new Game();
        $game->createRaces(1);

        return redirect('/');
    }

    /**
     * increments fake time by 10 seconds
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function progress()
    {
        FakeTime::getInstance()->increment(10);

        return redirect('/');
    }
}

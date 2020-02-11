@extends("layout")

@section('title', 'Awesome Horse race simulator')

@section('content')
    <div class="text-center">
        <h1>Awesome Horse race simulator</h1>

        <div class="row">
            <div class="col-sm text-right">
                <form action="/race" method="post">
                    @csrf
                    <input type="submit" value="Create a race"/>
                </form>
            </div>
            <div class="col-sm text-left">
                <form action="/progress" method="post">
                    @csrf
                    <input type="submit" value="Progress"/>
                </form>
            </div>
        </div>

        <h3>Current time: {{ $currentDateTime }}</h3>

        <h2>Current races</h2>
        @if(sizeof($currentRacesStats))

            @foreach($currentRacesStats as $currentRaceStats)
                <h4>Race #{{ $currentRaceStats->getRace()->id }}</h4>
                <table class="table table-bordered">
                    <tr>
                        <th>Position</th>
                        <th>Horse name</th>
                        <th>Distance</th>
                    </tr>
                    @foreach($currentRaceStats->getPositions() as $position => $horseId)
                        <tr>
                            <td>{{ $position+1 }}</td>
                            <td>{{ $currentRaceStats->getHorsesById()[$horseId]->name }}</td>
                            <td>{{ $currentRaceStats->getCoveredDistances()[$horseId] }}</td>
                        </tr>
                    @endforeach
                </table>
            @endforeach

        @else
            No information. Create a race and push the Progress button
        @endif

        <h2>Last 3 complete races</h2>

        @if(sizeof($lastCompletedRacesStats))
            @foreach($lastCompletedRacesStats as $completedRaceStats)
                <h4>Race #{{ $completedRaceStats->getRace()->id }}</h4>
                <table class="table table-bordered">
                    <tr>
                        <th>Position</th>
                        <th>Horse name</th>
                        <th>Distance</th>
                    </tr>
                    @foreach($completedRaceStats->getPositions() as $position => $horseId)
                        <tr>
                            <td>{{ $position+1 }}</td>
                            <td>{{ $completedRaceStats->getHorsesById()[$horseId]->name }}</td>
                            <td>{{ $completedRaceStats->getCoveredDistances()[$horseId] }}</td>
                        </tr>
                    @endforeach
                </table>
            @endforeach
        @else
            No information. Create a race and push the Progress button
        @endif

        <h2>The best horse ever</h2>

        @if($bestHorseEver instanceof \App\Horse)
            <table class="table">
                <tr>
                    <td>Name</td>
                    <td>{{ $bestHorseEver->name }} s</td>
                </tr>
                <tr>
                    <td>Finish time</td>
                    <td>{{ $bestHorseEver->finish_time }} s</td>
                </tr>
                <tr>
                    <td>Speed</td>
                    <td>{{ $bestHorseEver->speed }}</td>
                </tr>
                <tr>
                    <td>Strength</td>
                    <td>{{ $bestHorseEver->strength }}</td>
                </tr>
                <tr>
                    <td>Endurance</td>
                    <td>{{ $bestHorseEver->endurance }}</td>
                </tr>
            </table>
        @else
            No information. Create a race and push the Progress button
        @endif
    </div>
@endsection

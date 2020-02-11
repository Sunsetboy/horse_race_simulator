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
                <table class="table">
                    @foreach($currentRaceStats->getPositions() as $position => $horseId)
                        <tr>
                            <td>{{ $position+1 }}</td>
                            <td>name</td>
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

        @else
            No information. Create a race and push the Progress button
        @endif

        <h2>The best horse ever</h2>

        @if($bestHorseEver instanceof \App\Horse)

        @else
            No information. Create a race and push the Progress button
        @endif
    </div>
@endsection

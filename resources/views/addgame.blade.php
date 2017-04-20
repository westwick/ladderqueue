@extends('layouts.app')

@section('head')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
@endsection

@section('content')
    <section class="row main-top-padder padbot">
        <div class="medium-6 medium-centered">
            <div class="panel">
                <h4 class="text-center">Add Game (csgo season 2)</h4>
                <form method="post" action="/create-game">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="medium-6 columns">
                            <select name="team1">
                                <option value="">Team 1 (Home)</option>
                                @foreach($teams as $team)
                                    <option value="{{$team->id}}">{{$team->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="medium-6 columns">
                            <select name="team2">
                                <option value="">Team 2 (Away)</option>
                                @foreach($teams as $team)
                                    <option value="{{$team->id}}">{{$team->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="medium-6 columns">
                            <select name="map">
                                <option value="tbd">Map (optional)</option>
                                <option value="cache">cache</option>
                                <option value="cobblestone">cobblestone</option>
                                <option value="dust2">dust2</option>
                                <option value="inferno">inferno</option>
                                <option value="mirage">mirage</option>
                                <option value="nuke">nuke</option>
                                <option value="overpass">overpass</option>
                                <option value="train">train</option>
                            </select>
                        </div>
                        <div class="medium-3 columns">
                            <input name="date" type="text" id="datepicker" placeholder="Date"/>
                        </div>
                        <div class="medium-3 columns">
                            <select name="time">
                                <option value="12:00">12:00</option>
                                <option value="13:00">13:00</option>
                                <option value="14:00">14:00</option>
                                <option value="15:00">15:00</option>
                                <option value="16:00">16:00</option>
                                <option value="17:00">17:00</option>
                                <option value="18:00" selected>18:00</option>
                                <option value="19:00">19:00</option>
                                <option value="20:00">20:00</option>
                                <option value="21:00">21:00</option>
                                <option value="22:00">22:00</option>
                                <option value="23:00">23:00</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="button button-full">Create Game</button>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="/js/moment.js"></script>
    <script src="/js/pikaday/pikaday.js"></script>
    <script>
        var picker = new Pikaday({
            field: document.getElementById('datepicker'),
            format: 'YYYY-MM-DD'
        });

        @if (session()->has('thedate'))
            picker.setDate('{{Session::get('thedate')}}')
        @endif
    </script>
    <script type="text/javascript">
        $('select').select2();
    </script>
@endsection

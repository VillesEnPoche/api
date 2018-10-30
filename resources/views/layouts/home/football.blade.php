@if(!empty($last_match) && !empty($next_match) )
    <div class="col-12 blue">
        <div class="row justify-content-between">
            <div class="col-12">
                <div class="title">
                    <div>{{ env('FOOTBALL_TEAM_NAME') }}</div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="col-12">
                    <div class="row match">
                        <div class="col-12 head">{{ __('home.football.last') }}</div>
                        <div class="col-12 date text-center">{{ $last_match->date->locale(app()->getLocale())->isoFormat('LLLL') }}<br>
                            {{ $last_match->stade_name }}</div>
                        <div class="col-6">
                            <div class="logo">
                                <img src="{{ Storage::url('football/logos/' . $last_match->t1_id . '.png') }}"
                                     class="img-fluid"/>
                                <div class="score">{{ $last_match->t1_score }}</div>
                            </div>
                            <div class="name">{{ $last_match->t1_name }}</div>
                        </div>
                        <div class="col-6">
                            <div class="logo">
                                <img src="{{ Storage::url('football/logos/' . $last_match->t2_id . '.png') }}"
                                     class="img-fluid"/>
                                <div class="score">{{ $last_match->t2_score }}</div>
                            </div>
                            <div class="name">{{ $last_match->t2_name }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="col-12">
                    <div class="row match">
                        <div class="col-12 head">{{ __('home.football.next') }}</div>
                        <div class="col-12 date text-center">{{ $next_match->date->locale(app()->getLocale())->isoFormat('LLLL') }}<br>
                        {{ $next_match->stade_name }}</div>
                        <div class="col-6">
                            <div class="logo">
                                <img src="{{ Storage::url('football/logos/' . $next_match->t1_id . '.png') }}"
                                     class="img-fluid"/>
                                <div class="score">{{ $next_match->t1_score }}</div>
                            </div>
                            <div class="name">{{ $next_match->t1_name }}</div>
                        </div>
                        <div class="col-6">
                            <div class="logo">
                                <img src="{{ Storage::url('football/logos/' . $next_match->t2_id . '.png') }}"
                                     class="img-fluid"/>
                                <div class="score">{{ $next_match->t2_score }}</div>
                            </div>
                            <div class="name">{{ $next_match->t2_name }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 text-right">
        <a href="{{ route('home') }}" class="btn btn-info"
           target="_blank">{{ __('home.football.plus') }}</a>
    </div>
@endif
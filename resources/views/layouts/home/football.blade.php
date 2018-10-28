@if(!empty($last_match) && !empty($next_match) )
    <div class="col-12">
        <div class="row justify-content-between">
            <div class="col-12 blue">
                <div class="title">
                    <div>{{ env('FOOTBALL_TEAM_NAME') }}</div>
                </div>
            </div>
            <div class="col-6">
                <div class="col-12">
                    <div class="row match">
                        <div class="col-12 date text-center">{{ __('home.football.last') }} {{ $last_match->date->locale(app()->getLocale())->isoFormat('dddd D MMMM') }}</div>
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
            <div class="col-6">
                <div class="col-12">
                    <div class="row match">
                        <div class="col-12 date text-center">{{ __('home.football.next') }} {{ $next_match->date->locale(app()->getLocale())->isoFormat('dddd D MMMM') }}</div>
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
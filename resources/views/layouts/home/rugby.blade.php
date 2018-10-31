@if(!empty($last_match_rugby) && !empty($next_match_rugby) )
    <div class="col-12 blue">
        <div class="row justify-content-between">
            <div class="col-12">
                <div class="title">
                    <div>{{ $rugby_name }}</div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="col-12">
                    <div class="row match">
                        <div class="col-12 head">{{ __('home.rugby.last') }}</div>
                        <div class="col-12 date text-center">{{ $last_match_rugby->date->locale(app()->getLocale())->isoFormat('LLLL') }}<br>
                            {{ $last_match_rugby->terrain }}</div>
                        <div class="col-6">
                            <div class="logo">
                                <img src="{{ Storage::url('rugby/' . str_slug($last_match_rugby->t1_name) . '.jpg') }}"
                                     class="img-fluid"/>
                                <div class="score">{{ $last_match_rugby->t1_score }}</div>
                            </div>
                            <div class="name">{{ $last_match_rugby->t1_name }}</div>
                        </div>
                        <div class="col-6">
                            <div class="logo">
                                <img src="{{ Storage::url('rugby/' . str_slug($last_match_rugby->t2_name) . '.jpg') }}"
                                     class="img-fluid"/>
                                <div class="score">{{ $last_match_rugby->t2_score }}</div>
                            </div>
                            <div class="name">{{ $last_match_rugby->t2_name }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="col-12">
                    <div class="row match">
                        <div class="col-12 head">{{ __('home.rugby.next') }}</div>
                        <div class="col-12 date text-center">{{ $next_match_rugby->date->locale(app()->getLocale())->isoFormat('LLLL') }}<br>
                        {{ $next_match_rugby->terrain }}</div>
                        <div class="col-6">
                            <div class="logo">
                                <img src="{{ Storage::url('rugby/' . str_slug($next_match_rugby->t1_name) . '.jpg') }}"
                                     class="img-fluid"/>
                                <div class="score">{{ $next_match_rugby->t1_score }}</div>
                            </div>
                            <div class="name">{{ $next_match_rugby->t1_name }}</div>
                        </div>
                        <div class="col-6">
                            <div class="logo">
                                <img src="{{ Storage::url('rugby/' . str_slug($next_match_rugby->t2_name ). '.jpg') }}"
                                     class="img-fluid"/>
                                <div class="score">{{ $next_match_rugby->t2_score }}</div>
                            </div>
                            <div class="name">{{ $next_match_rugby->t2_name }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 text-right">
        <a href="{{ route('home') }}" class="btn btn-info"
           target="_blank">{{ __('home.rugby.plus') }}</a>
    </div>
@endif
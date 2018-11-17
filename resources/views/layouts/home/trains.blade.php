@if(!empty($trains['arrivals']) && !empty($trains['departures']))
    <div class="col-12">
        <div class="row orange justify-content-between">
            <div class="col-12">
                <div class="title">
                    <div>{{ __('home.trains.title', ['city' => $city]) }}</div>
                </div>
            </div>
            @if(count($trains_alerts))
                <div class="col-12">
                    @foreach($trains_alerts as $trains_alert)
                        <div class="alert alert-warning">
                            {{ $trains_alert->content }}
                        </div>
                    @endforeach
                </div>
            @endif
            @foreach(['departures', 'arrivals'] as $type)
                <div class="col-6">
                    <div class="col-12">
                        <div class="row trains_station">
                            <table class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th colspan="3" class="text-center">{{ __('home.trains.' . $type) }}</th>
                                </tr>
                                <tr>
                                    <th class="nob">{{ __('home.trains.hour') }}</th>
                                    <th class="nob">{{ __('home.trains.origin') }}</th>
                                    <th class="text-center">{{ __('home.trains.way') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach(array_slice($trains[$type]->json[$type], 0, 6) as $train)
                                    <tr class="link-black">
                                        <td>
                                            <a href="{{ route('details.train', ['numero' => $train['numero'], 'name' => str_slug($train['destination'] . $train['origine'])]) }}">{{ Carbon\Carbon::createFromTimeString($train['date'])->format('H:i') }}
                                                <br>
                                                <small>
                                                    ({{ Carbon\Carbon::createFromTimeString($train['date'])->shortRelativeDiffForHumans(2) }}
                                                    )
                                                </small>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('details.train', ['numero' => $train['numero'], 'name' => str_slug($train['destination'] . $train['origine'])]) }}">{{ $train['destination'] . $train['origine'] }}
                                                <br>
                                                <small>n°{{ $train['numero'] }}</small>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('details.train', ['numero' => $train['numero'], 'name' => str_slug($train['destination'] . $train['origine'])]) }}">
                                                @if($train['mode'] === 'Car')
                                                    <img src="{{ asset('images/icons/bus.png') }}" width="20px"/>
                                                @else
                                                    {{ $train['voie'] }}
                                                @endif
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
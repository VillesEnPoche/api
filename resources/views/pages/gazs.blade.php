@extends('home')

@section('title', __('menu.convenience.submenu.gazs'))

@section('content')
    <div class="title">
        <div class="purple">{{ __('menu.convenience.submenu.gazs') }}</div>
    </div>

    @foreach($stations as $station)
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>{{ $station->name }}<br>{{ $station->address }}</th>
                <th class="text-right"><br>{{ $station->city }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($station->prices()->get() as $price)
                <tr class="{{ $price->isExpired() ? 'expired' : '' }}" title="{{ __('gaz.last_update') }} {{ $price->created_at->locale(app()->getLocale())->diffForHumans() }} ({{ $price->created_at->format('d/m H:i') }})">
                    <td>{{ $price->gas }} {{ $price->isExpired() ? '*' : '' }}
                        @if($price->isExpired())
                            <span class="last-update">{{ __('gaz.last_update') }} {{ $price->created_at->locale(app()->getLocale())->diffForHumans() }}</span>
                        @endif
                    </td>
                    <td class="text-right">
                        @if($price->lowPrice())
                            <span class="cheaper">{{ __('gaz.cheaper') }} {{ $price->price }} €</span>
                        @else
                            {{ $price->price }} €
                        @endif</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endforeach
@endsection
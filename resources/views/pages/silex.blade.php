@extends('home')

@section('title', __('menu.go_out.submenu.silex'))

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="title">
                <div>{{ __('menu.go_out.submenu.silex') }}</div>
            </div>
        </div>
    </div>

    @foreach($events as $event)
        <div class="row block">
            <div class="col-9 name">
                {{ $event->name }}
            </div>
            <div class="col-3 text-right">
                {{ $event->description }}
            </div>
            <div class="col-sm-3 col-md-2">
                <img src="{{ Storage::disk('public')->url($event->pictures()->orderBy('order')->first()->path) }}"
                     class="img-fluid"/>
            </div>
            <div class="col-sm-9 col-md-10">
                {{ $event->start->locale(app()->getLocale())->diffForHumans() }} {{ __('silex.event.start') }}
                {{ $event->start->locale(app()->getLocale())->isoFormat('dddd D MMMM Y') }}
                {{ __('silex.event.at') }}
                {{ $event->start->format('H:i') }}
                @if(!empty($event->end))
                    {{ __('silex.event.end') }}
                    {{ $event->end->format('H:i') }}
                @endif
            </div>

            @if(!empty($event->link))
                <div class="col-12 text-right">
                    <a href="{{ $event->link }}" class="btn btn-info"
                       target="_blank">{{ __('silex.event.buy_ticket') }}</a>
                </div>
            @endif
        </div>
    @endforeach
@endsection
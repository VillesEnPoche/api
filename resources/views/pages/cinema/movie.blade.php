@extends('home')

@section('title', __('menu.go_out.submenu.cinema'))

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="title">
                <div>
                    <a href="{{ route('cinema') }}">{{ __('menu.go_out.submenu.cinema') }}</a> - {{ $movie->title }}
                </div>
            </div>
        </div>
    </div>

    <div class="row block movie">
        <div class="col-12">
            @if(!empty($movie->synopsis))
                <div class="synopsis">
                    {{ __('cinema.movie.synopsis') }}
                    <span>{{ $movie->synopsis }}</span>
                </div>
            @endif
            @if(!empty($movie->rating))
                <div class="rating pb-2">
                    {{ __('cinema.movie.rating', ['rating' => round($movie->rating, 2)]) }}
                </div>
            @endif
            @if(!empty($movie->release))
                <div class="release" title="{{ $movie->release->diffForHumans() }}">{{ __('cinema.movie.release') }}
                    <span>{{ $movie->release->isoFormat('dddd Do MMMM YYYY') }}</span></div>
            @endif
            @if(!empty($movie->runtime))
                <div class="runtime">{{ __('cinema.movie.runtime') }}
                    <span>{{ gmdate('G \h i', $movie->runtime) }} min</span></div>
            @endif
            @if(!empty($movie->genres))
                <div class="genres">{{ trans_choice('cinema.movie.genres', count($movie->genres)) }}
                    @foreach($movie->genres as $genre)
                        <span>{{ $genre }}
                            @if(!$loop->last)
                                ,
                            @endif
                        </span>
                    @endforeach
                </div>
            @endif
            @if(!empty($movie->directors))
                <div class="directors">
                    {{ trans_choice('cinema.movie.directors', count($movie->directors)) }}
                    @foreach($movie->directors as $director)
                        <span>{{ $director }}
                            @if(!$loop->last)
                                ,
                            @endif</span>
                    @endforeach
                </div>
            @endif
            @if(!empty($movie->actors))
                <div class="actors">
                    {{ trans_choice('cinema.movie.actors', count($movie->actors)) }}
                    @foreach($movie->actors as $actor)
                        <span>{{ $actor }}
                            @if(!$loop->last)
                                ,
                            @endif</span>
                    @endforeach
                </div>
            @endif
            <div class="text-center p-4">
                <img class="img-fluid"
                     src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url(str_replace('theater', 'theater/medium', $movie->path_poster)) }}"/>
            </div>
        </div>
    </div>

    @if(!empty($sessions))
    <div class="row">
        <div class="col-12">
            <div class="title">
                <div>
                    {{ __('cinema.movie.times') }}
                </div>
            </div>
        </div>
    </div>

    <div class="row block movie">
        @foreach($sessions as $date => $times)
            <div class="session col-md-4 col-sm-6">
                <div class="date">{{ Carbon\Carbon::createFromFormat('Y-m-d', $date)->isoFormat('dddd Do MMMM YYYY') }}</div>
                @foreach($times as $time)
                    <div class="time row">
                        <span class="hour col-md-5">{{ $time->date->format('H:i') }}</span>
                        <span class="lang col-md-5">{{ $time->lang }}</span>
                        <span class="is_3d col-md-2">@if($time->is_3d)
                                3D
                            @endif</span>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
    @endif

    @if(!empty($movie->path_trailer))
    <div class="row">
        <div class="col-12">
            <div class="title">
                <div>
                    {{ __('cinema.movie.trailer') }}
                </div>
            </div>
        </div>
    </div>

    <div class="row block movie">
        <div class="col-12 trailer">
            <video controls src="{{ $movie->path_trailer }}">{{ $movie->title }}</video>
        </div>
    </div>
    @endif

@endsection
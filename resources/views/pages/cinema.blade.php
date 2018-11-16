@extends('home')

@section('title', __('menu.go_out.submenu.cinema'))

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="title">
                <div>{{ __('menu.go_out.submenu.cinema') }}</div>
            </div>
        </div>
    </div>

    @foreach($movies as $movie)
        <div class="row block movie">
            <div class="col-8">
                <div class="title_movie">{{ $movie->title }}</div>
                <div class="next">{{ __('cinema.movie.next') }} {{ Carbon\Carbon::createFromTimeString($movie->date)->format('d/m H:i') }}
                    <span>({{ Carbon\Carbon::createFromTimeString($movie->date)->shortRelativeDiffForHumans(2) }})</span></div>

                @if(!empty($movie->synopsis))
                <div class="synopsis">
                    {{ __('cinema.movie.synopsis') }}
                    <span>{{ $movie->synopsis }}</span>
                </div>
                @endif
                @if(!empty($movie->release))
                <div class="release" title="{{ $movie->release->diffForHumans() }}">{{ __('cinema.movie.release') }} <span>{{ $movie->release->isoFormat('dddd Do MMMM YYYY') }}</span></div>
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
            </div>
            <div class="col-4">
                <img class="img-fluid"
                     src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url(str_replace('theater', 'theater/small', $movie->path_poster)) }}"/>
            </div>
        </div>
    @endforeach
@endsection
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
            <div class="col-md-8 col-sm-12">
                <div class="title_movie"><a href="{{ route('movie', ['id' => $movie->id, 'slug' => str_slug($movie->title)]) }}">{{ $movie->title }}</a></div>
                <div class="next">{{ __('cinema.movie.next') }} {{ Carbon\Carbon::createFromTimeString($movie->date)->format('d/m H:i') }}
                    <span>({{ Carbon\Carbon::createFromTimeString($movie->date)->shortRelativeDiffForHumans(2) }}
                        )</span></div>

                <a href="{{ route('movie', ['id' => $movie->id, 'slug' => str_slug($movie->title)]) }}" class="m-auto d-md-none d-sm-block"><img class="img-fluid" src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url(str_replace('theater', 'theater/small', $movie->path_poster)) }}"/></a>

                @if(!empty($movie->synopsis))
                    <div class="synopsis">
                        {{ __('cinema.movie.synopsis') }}
                        <span>{{ $movie->synopsis }}</span>
                    </div>
                @endif
                @if(!empty($movie->release))
                    <div class="release" title="{{ $movie->release->diffForHumans() }}">{{ __('cinema.movie.release') }}
                        <span>{{ $movie->release->isoFormat('dddd Do MMMM YYYY') }}</span></div>
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

                @if(count($movie->today()))
                    <div class="session col-12 pb-2 pt-2">
                        <div style="font-weight: bold;">{{ __('cinema.movie.next_sessions') }}</div>
                        @foreach($movie->today() as $time)
                            <div class="time row">
                                <span class="hour col-5">{{ $time->date->format('H:i') }}</span>
                                <span class="lang col-5">{{ $time->lang }}</span>
                                <span class="is_3d col-2">@if($time->is_3d)
                                        3D
                                    @endif</span>
                            </div>
                        @endforeach
                    </div>
                @endif
                <div class="show">
                    <a href="{{ route('movie', ['id' => $movie->id, 'slug' => str_slug($movie->title)]) }}"
                       class="btn btn-info">{{ __('cinema.movie.details') }}</a>
                </div>
            </div>
            <div class="col-md-4 d-sm-none d-none d-md-block text-center">
                <a href="{{ route('movie', ['id' => $movie->id, 'slug' => str_slug($movie->title)]) }}"><img class="img-fluid"
                       src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url(str_replace('theater', 'theater/small', $movie->path_poster)) }}"/></a>
            </div>
        </div>
    @endforeach
@endsection
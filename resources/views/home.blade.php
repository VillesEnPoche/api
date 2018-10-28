<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <title>@yield('title') - {{ env('APP_NAME') }}</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{mix('css/app.css')}}" rel="stylesheet" type="text/css">
    <meta name="description" content="@yield('meta-description', 'Retrouvez toutes les informations concernant la ville d\'' . env('APP_CITY') . ' en une seule et unique web-application')" />
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="@yield('canonical', env('APP_TWITTER'))" />
    <meta name="twitter:creator" content="@yield('canonical', env('APP_TWITTER'))" />
    <link rel="canonical" href="@yield('canonical', env('APP_URL'))" />
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-black mb-4">
    <a class="navbar-brand" href="{{ route('home') }}"><img src="{{ asset('images/logo.png') }}" id="logo"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
</nav>
<main role="main" class="container mt-2 {{ (isset($color)) ? $color : '' }}">
    <div class="row">
        <div class="col-sm col-md-4 col-lg-3 menu">
            @include('layouts.menu');
        </div>
        <div class="col-sm-12 col-md-8 col-lg-9 content">
            @yield('content')
        </div>
    </div>
</main>
<script src="{{mix('js/app.js')}}"></script>
<script src="{{mix('js/all.js')}}"></script>
</body>
</html>
<div class="collapse show navbar-collapse" id="navbarCollapse">
    <ul class="navbar-nav mr-auto">
        <li class="nav-item category">
            <span class="nav-link">{{ __('menu.daily.title') }}</span>
        </li>
        <a class="nav-link page" href="#">
            <li class="nav-item">
                <img src="{{ asset('images/icons/weather.png') }}">
                {{ __('menu.daily.submenu.weather') }}
            </li>
        </a>
        <a class="nav-link page" href="#">
            <li class="nav-item">
                <img src="{{ asset('images/icons/news.png') }}">
                {{ __('menu.daily.submenu.news') }}
            </li>
        </a>
        <a class="nav-link page" href="#">
            <li class="nav-item">
                <img src="{{ asset('images/icons/tv.png') }}">
                {{ __('menu.daily.submenu.tv') }}
            </li>
        </a>
        <li class="nav-item category">
            <span class="nav-link">{{ __('menu.go_out.title') }}</span>
        </li>
        <a class="nav-link page" href="#">
            <li class="nav-item">
                <img src="{{ asset('images/icons/silex.png') }}">
                {{ __('menu.go_out.submenu.silex') }}
            </li>
        </a>
        <a class="nav-link page" href="#">
            <li class="nav-item">
                <img src="{{ asset('images/icons/theater.png') }}">
                {{ __('menu.go_out.submenu.theater') }}
            </li>
        </a>
        <a class="nav-link page" href="#">
            <li class="nav-item">
                <img src="{{ asset('images/icons/football.png') }}">
                {{ __('menu.go_out.submenu.football') }}
            </li>
        </a>
        <a class="nav-link page" href="#">
            <li class="nav-item">
                <img src="{{ asset('images/icons/cinema.png') }}">
                {{ __('menu.go_out.submenu.cinema') }}
            </li>
        </a>
        <li class="nav-item category">
            <span class="nav-link">{{ __('menu.convenience.title') }}</span>
        </li>
        <a class="nav-link page" href="{{ route('gazs') }}">
            <li class="nav-item">
                <img src="{{ asset('images/icons/gazs.png') }}">
                {{ __('menu.convenience.submenu.gazs') }}
            </li>
        </a>
        <li class="nav-item category">
            <span class="nav-link">{{ __('menu.move.title') }}</span>
        </li>
        <li class="nav-item category">
            <span class="nav-link">{{ __('menu.emergency.title') }}</span>
        </li>
    </ul>
</div>
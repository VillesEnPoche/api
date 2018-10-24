<div class="collapse show navbar-collapse" id="navbarCollapse">
    <ul class="navbar-nav mr-auto">
        @foreach(Lang::get('menu') as $category => $menu)
            @if(env('MENU_ENABLE_' . strtoupper($category)) == true)
                <li class="nav-item category">
                    <span class="nav-link">{{ $menu['title'] }}</span>
                </li>
                @if(!empty($menu['submenu']))
                    @foreach($menu['submenu'] as $key => $title)
                        @if(env('SUBMENU_DISABLE_' . strtoupper($key)) != true)
                            <a class="nav-link page {{ (Route::currentRouteName() == $key) ? 'active' : '' }}" href="{{ (Route::has($key) ? route($key) : '#') }}">
                                <li class="nav-item">
                                    <img src="{{ asset('images/icons/' . $key . '.png') }}">
                                    {{ $title }}
                                </li>
                            </a>
                        @endif
                    @endforeach
                @endif
            @endif
        @endforeach
    </ul>
</div>
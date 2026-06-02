<header class="page_header transparent_header doted_items section_padding_10 columns_padding_0 table_section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 col-sm-5 col-xs-6">
                <a href="{{ url('/') }}" class="logo logo_image">
                    <img src="{{ asset('theme/images/logo.png') }}" alt="Ovatify">
                </a>
                <span class="toggle_menu visible-xs"><span></span></span>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-2 col-xs-6 text-center">
                <nav class="mainmenu_wrapper">
                    <ul class="mainmenu nav sf-menu">
                        <li class="{{ request()->is('/') ? 'active' : '' }}">
                            <a href="{{ url('/') }}">Home</a>
                        </li>
                        <li class="{{ request()->is('marketplace/music') ? 'active' : '' }}">
                            <a href="{{ url('/marketplace/music') }}">Music</a>
                        </li>
                        <li class="{{ request()->is('marketplace/images') ? 'active' : '' }}">
                            <a href="{{ url('/marketplace/images') }}">Images</a>
                        </li>
                        <li class="{{ request()->is('marketplace/merchandise') ? 'active' : '' }}">
                            <a href="{{ url('/marketplace/merchandise') }}">Merchandise</a>
                        </li>
                        <li class="{{ request()->is('business') ? 'active' : '' }}">
                            <a href="{{ url('/business') }}">Business</a>
                        </li>
                        @guest
                            <li><a href="{{ route('register') }}">Join</a></li>
                            <li><a href="{{ route('login') }}">Login</a></li>
                        @else
                            <li><a href="{{ route('consumer.dashboard.index') }}">Dashboard</a></li>
                        @endguest
                    </ul>
                </nav>
                <span class="toggle_menu hidden-xs"><span></span></span>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-5 text-right hidden-xs">
                <ul class="inline-dropdown inline-block">
                    <li>
                        <a class="header-button search_modal_button" href="#">
                            <i class="flaticon-magnifying-glass"></i>
                        </a>
                    </li>
                    <li class="dropdown login-dropdown">
                        <a class="header-button" href="#" data-toggle="dropdown">
                            <i class="flaticon-avatar"></i>
                        </a>
                        <div class="dropdown-menu ls" aria-labelledby="login">
                            @auth
                                <div style="padding:15px 20px;">
                                    <p class="bold grey">{{ Auth::user()->username }}</p>
                                    <a href="{{ route('consumer.dashboard.index') }}" class="theme_button" style="display:block;margin-bottom:8px;">Dashboard</a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="theme_button color2" style="width:100%;">Logout</button>
                                    </form>
                                </div>
                            @else
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-group bottommargin_10">
                                        <input type="email" class="form-control" name="email" placeholder="Email" required>
                                    </div>
                                    <div class="form-group bottommargin_10">
                                        <input type="password" class="form-control" name="password" placeholder="Password" required>
                                    </div>
                                    <button type="submit" class="theme_button">Login</button>
                                </form>
                                <div class="greylinks topmargin_15 text-center">
                                    <a href="{{ route('register') }}">Create Account</a>
                                </div>
                            @endauth
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
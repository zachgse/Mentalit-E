<nav class="navbar navbar-expand-lg navbar-light py-3 fixed-top">
    <div class="container">
        <a class="navbar-brand" href="/">
            <img src="{{asset('img/logo.png')}}" width=150>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                <!-- Authentication Links -->
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                    @elseif(Auth::user()->userType == 'SystemAdmin')
                    <li class="nav-item">
                        <a class="nav-link" href="/forum">Community Forum</a>
                    </li>  
                    <li class="nav-item">
                        <a class="nav-link" href="/profile/profile/index">Profile</a>
                    </li> 
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->firstName }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>  
                    @elseif(Auth::user()->userType== 'ClinicAdmin')
                    <li class="nav-item">
                        <a class="nav-link" href="/forum">Community Forum</a>
                    </li> 
                    <li class="nav-item">
                        <a class="nav-link" href="/clinic/clinic/single">Clinic</a>
                    </li>      
                    <li class="nav-item">
                        <a class="nav-link" href="/profile/profile/index">Profile</a>
                    </li>                                                 
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->firstName }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                    @elseif(Auth::user()->userType == 'ClinicEmployee')
                    <li class="nav-item">
                        <a class="nav-link" href="/forum">Community Forum</a>
                    </li> 
                    <li class="nav-item">
                        <a class="nav-link" href="/clinic/clinic/single">Clinic</a>
                    </li>                  
                    <li class="nav-item">
                        <a class="nav-link" href="/profile/profile/index">Profile</a>
                    </li> 
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->firstName }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>                           
                    @elseif(Auth::user()->userType == 'Patient') 
                    <li class="nav-item">
                        <a class="nav-link" href="/forum">Community Forum</a>
                    </li>  
                    <li class="nav-item">
                        <a class="nav-link" href="/booking/quick">Quick Booking</a>
                    </li>  
                    <li class="nav-item">
                        <a class="nav-link" href="/booking">Manual Booking</a>
                    </li>                    
                    <li class="nav-item">
                        <a class="nav-link" href="/profile/profile/index">Profile</a>
                    </li> 
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->lastName}}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{asset('images/logo.ico')}}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{asset('images/logo.png')}}" alt="FAOU logo" style="height:50px;width:50px;">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" ></a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#"></a>
                            </div>
                        </li> -->
                        @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Interviews</a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="{{route('InterviewsHome')}}">Interviews</a>
                                <a class="dropdown-item" href="{{route('viewdefault')}}">Applications</a>
                                <a class="dropdown-item" href="{{route('AddApplications')}}">Add Applications</a>
                            </div>
                        </li>
                        @endauth


                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('home') }}">Home</a>
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

        <main class="py-4" style="min-height:58vh;">
            @yield('content')
        </main>

        <footer>
            <div class="jumbotron">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <img src="{{asset('images/llogo.png')}}" style="width:100%;height:110px;" alt="FAOU logo">
                    </div>
                    <div class="col-md-8">
                        <div class="row justify-content-around">
                            <div class="col-md-6" style="text-align:center">
                                <p>© Copyright 2021-{{date("Y")}} Fatima Al-Fihri Open University. <br>Tallinn - Estonia.<br>Email: <a href="mailto:contact@alfihri.org">contact@alfihri.org</a> || Phone: (34) 641-49-9857</p>
                            </div>
                            <div class="col-md-6" style="text-align:center">
                                <p>This website is not the official website of <a target="_blank" href="https://www.alfihri.org/">FAOU</a><br>Created by <a target="_blank" href="https://www.linkedin.com/in/brahim-benzarti-227069152/">Brahim Benzarti</a> ,an Undergrad at <a target="_blank" href="http://www.tunis-business-school.tn/">TBS,</a> as an Internship project with FAOU.</p>
                            </div>
                        </div>
                        <div class="row justify-content-center mt-3">
                            <div class="col-md-8 d-flex justify-content-around">
                                <a target="_blank" href="https://www.facebook.com/enFAOU"><img style="width:40px" src="{{asset('icons/facebook.png')}}" alt="facebook icon"></a>
                                <a target="_blank" href="https://twitter.com/enFAOU"><img style="width:40px" src="{{asset('icons/twitter.png')}}" alt="twitter icon"></a>
                                <a target="_blank" href="https://www.youtube.com/channel/UCpxOvkfMmAO5dzEVrweyF1g"><img style="width:40px" src="{{asset('icons/youtube.png')}}" alt="youtube icon"></a>
                                <a target="_blank" href="https://www.linkedin.com/company/enfaou/mycompany/"><img style="width:40px" src="{{asset('icons/linkedin.png')}}" alt="linkedin icon"></a>
                                <a target="_blank" href="https://www.instagram.com/enfaou/"><img style="width:40px" src="{{asset('icons/instagram.png')}}" alt="linkedin icon"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="#">
    <meta name="author" content="#">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Onlineinsurance') }}</title>
    
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard/adminty/files/assets/icon/icofont/css/icofont.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard/adminty/files/assets/icon/font-awesome/css/font-awesome.min.css')}}">
    
    
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}
    {{-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js" type="text/javascript"></script> --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"> </script>
    
    
    
    {{-- SWEET ALERT --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard/adminty/files/assets/css/sweetalert2.min.css')}}">
    
    {{-- DATE PICKER --}}
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('dashboard/adminty/files/bower_components/bootstrap-daterangepicker/css/daterangepicker.css')}}" /> --}}
    {{-- DATATABLE --}}
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    
    
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                @auth
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{-- {{ config('app.name', 'Onlineinsurance') }} --}}
                    <img style="height: 40px; object-fit: cover; width: 100%;" src="{{ asset('onlineinsurance.png') }}" alt="">
                </a>
                @endauth
                &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        
                        
                        @auth
                        
                        <a style="font-size: 15px;" class="navbar-brand" href="{{ url('/home') }}">Home</a>
                        <li class="nav-item dropdown">
                            <a style="font-size: 15px;" id="navbarDropdown1" class="navbar-brand dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Salesrep
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown1">
                                
                                <a class="dropdown-item" href="{{ url('salesrep/profiles') }}">Salesrep Profiles</a>
                                <a class="dropdown-item" href="{{ url('salesrep/create') }}"">Create Salesrep Profiles</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a style="font-size: 15px;" id="navbarDropdown2" class="navbar-brand dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Payroll
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown2">
                                
                                <a class="dropdown-item" href="{{ url('payroll/index') }}">Payroll</a>
                                <a class="dropdown-item" href="{{ url('payroll/create') }}">Create Payroll</a>
                            </div>
                        </li>
                        @endauth
                    </ul>
                    
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                        @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @endauth
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>
                            
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
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
    
    <main class="py-4">
        @yield('content')
    </main>
</div>

<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js" defer></script>
{{-- <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script> --}}
{{-- <script src ="http://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js" defer></script> --}}
<script src="{{ asset('js/base_url.js') }}"></script>
{{-- SWEET ALERT --}}
<script src="{{ asset('dashboard/adminty/files/assets/js/sweetalert2.all.min.js')}}"></script>
<script src="{{ asset('dashboard/adminty/files/assets/js/jquery.form.min.js')}}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" defer integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="text/javascript" src="{{ asset('dashboard/adminty/files/assets/pages/advance-elements/moment-with-locales.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('dashboard/adminty/files/bower_components/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('dashboard/adminty/files/assets/pages/advance-elements/bootstrap-datetimepicker.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('dashboard/adminty/files/bower_components/bootstrap-daterangepicker/js/daterangepicker.js')}}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js" defer integrity="sha512-Rdk63VC+1UYzGSgd3u2iadi0joUrcwX0IWp2rTh6KXFoAmgOjRS99Vynz1lJPT8dLjvo6JZOqpAHJyfCEZ5KoA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>
</html>

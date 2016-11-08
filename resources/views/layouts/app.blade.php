<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @stack('metacode')

    <title>Pimpinan Cabang Muhammadiyah | Kartasura @yield('title')</title>

    <!-- Fonts -->
{{--     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700"> --}}

    <!-- Styles -->
    <link rel="stylesheet" href="{{ URL::asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/font-awesome/font-awesome.css') }}">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    <style>
        /* Sticky footer styles
        -------------------------------------------------- */
        html {
          position: relative;
          min-height: 100%;
        }
        body {
          /* Margin bottom by footer height */
          margin-bottom: 60px;
          /*font-family: 'Lato';*/
          padding-top: 80px;
          background-color: #F5F5F5;
        }
        .footer {
          position: absolute;
          bottom: 0;
          width: 100%;
          /* Set the fixed height of the footer here */
          height: 60px;
          line-height: 60px; /* Vertically center the text there */
          background-color: #003056;
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
    @stack('csscode')
</head>
<body id="app-layout">
    <nav class="navbar navbar-dark navbar-fixed-top" style="background-color: #003056">
      <div class="container">
        <div class="clearfix hidden-lg-up">
            <a class="navbar-brand" href="{{ url('/') }}">Navigasi</a>
            <button class="navbar-toggler hidden-lg-up float-xs-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"></button>
        </div>
        <div class="collapse navbar-toggleable-md" id="navbarResponsive">
{{--         <ul class="nav navbar-nav">
        </ul> --}}
        {{-- navbar right --}}
        <a class="navbar-brand" href="{{ url('/') }}"><span class="fa fa-building-o"></span>&nbsp; Portal PCM Kartasura</a>
        <ul class="nav navbar-nav float-lg-right">
          <li class="nav-item active">
            <a class="nav-link" href="{{ url('/home') }}">Home <span class="sr-only">(current)</span></a>
          </li>
            @if (Auth::guest())
                <li class="nav-item"><a class="nav-link" href="{{ url('/login') }}">Login</a></li>
                {{-- <li class="nav-item"><a class="nav-link" href="{{ url('/register') }}">Register</a></li> --}}
            @else
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Kelola Akun &nbsp; <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu" aria-labelledby="profileDropdown">
                        <a class="dropdown-item" href="#"><i class="fa fa-btn fa-pencil"></i>Buat Tulisan</a>
                        <a class="dropdown-item" href="#"><i class="fa fa-btn fa-user"></i>{{ Auth::user()->name }}</a>
                        <a class="dropdown-item" href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a>
                    </div>
                </li>
            @endif
        </ul> {{-- end navbar right --}}
        </div> {{-- toggleable --}}
      </div> {{-- container --}}
    </nav>
    @yield('content')

    {{-- footer --}}
    <footer class="footer">
      <div class="container">
        <span class="text-white">&copy; 2016 - Cabang Muhammadiyah Kartasura</span>
      </div>
    </footer>

    {{-- js --}}
    <script type="text/javascript" src="{{ URL::asset('assets/js/jquery-1.12.0.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/js/bootstrap.min.js') }}"></script>
    @stack('jscode')
</body>
</html>

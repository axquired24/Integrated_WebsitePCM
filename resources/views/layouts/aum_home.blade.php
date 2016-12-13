<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @stack('metacode')

    <title>@yield('title') - {{ $aum->name }}</title>

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
          background-color: #F5F5F5;
        }
        .footer {
          position: absolute;
          bottom: 0;
          width: 100%;
          /* Set the fixed height of the footer here */
          height: 60px;
          line-height: 60px; /* Vertically center the text there */
          background-color: rgba(254,0,0,1);
        }

        .navbar-transparent {
          -webkit-transition: all 0.25s ease-out;
          transition: all 0.25s ease-out;
          background-color: rgba(0,0,0,0);
        }

        .shrink {
          -webkit-transition: all 0.25s ease-in;
          transition: all 0.25s ease-in;
          background-color: rgba(254,0,0,1);
          padding-top: 15px;
          padding-bottom: 15px;
        }

        .nav.navbar-nav > li > a:link {
          color: rgba(255,255,255,1) !important;
        }

        .nav.navbar-nav > li > a:hover {
          color: rgba(255,255,255,0.75) !important;
        } 

        .bg-sekolah {
          background-color: rgba(254,0,0,1);
        }

        .text-sekolah {
          color: rgba(254,0,0,1);
        }

        .text-sekolah:hover {
          color: rgba(254,0,0,1);
        }        

        .text-sekolah a, .text-sekolah a:hover {
          color: rgba(254,0,0,1);
          text-decoration: none;
        }

        .text-lg-2 {
          font-size: 1.5rem;
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
    @stack('csscode')
</head>
<body id="app-layout">
    <nav id="navtop" class="navbar navbar-dark navbar-fixed-top navbar-transparent">
      <div class="container">
        <div class="clearfix hidden-lg-up">
            <a class="navbar-brand" href="{{ url('aum/'.$aum->seo_name.'/home') }}">Navigasi</a>
            <button class="hidden-lg-up float-xs-right btn btn-link text-white" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="fa fa-navicon"></span></button>
        </div>
        <div class="collapse navbar-toggleable-md" id="navbarResponsive">
{{--         <ul class="nav navbar-nav">
        </ul> --}}
        {{-- navbar right --}}
        <a class="navbar-brand" href="{{ url('aum/'.$aum->seo_name.'/home') }}"><span class="fa fa-building-o"></span>&nbsp; {{ $aum->name }}</a>
        <ul class="nav navbar-nav float-lg-right">
          {{-- Include Menu_Order --}}
          @include('layouts.pcm_menu')
            @if (Auth::guest())
                <li class="nav-item"><a class="nav-link" href="{{ url('/login') }}">Login</a></li>                
            @else
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="fa fa-user"></span>&nbsp; Akun <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu">
                        <a title="{{ Auth::user()->name }} : Kelola Halaman & Profil" class="dropdown-item" href="{{ url('admin') }}">{{ Auth::user()->name }}</a>
                        <a class="dropdown-item" href="{{ url('/logout') }}">Logout</a>
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
    <script type="text/javascript" src="{{ URL::asset('assets/js/tether.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript">
      $(window).scroll(function(){
        if($(document).scrollTop() > 50){
          $('#navtop').addClass('shrink');
        }
        else {
          $('#navtop').removeClass('shrink');
        }
      });

      $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
        $('[data-toggle="tooltip"]').css({'cursor':'pointer'});
      });      
    </script>
    @stack('jscode')
</body>
</html>

<!--
      Ax-Store Developed By AxQuired Studio

   X@%o
 o#####@
 #@   o#@
%#     X#
@#     .#o   ..................
@#     .#o  .##################
X#o    @#                    .#.
 ##X .@#X                     #.                                       .                 X
  @####%                                     #           X@X@X                          .@
   .oo                                      o@X         .%   %o                         .@
                                            @ @   %  oX %     % oo  .o o. XX@  X%@.  o@%%@
                  %%.                       X X.   % @  @     @ oo  oo Xo XX  oX  @  @  X@
                 %##@                      %   %   o#.  @     @ oo  oo Xo X.  @X..@ oo  .@
    o#           ####                      #@%@#   .#   %     @ oo  oo Xo X.  @o... Xo  .@
    o#          .##@#X                    oX   Xo  @.@  oX   Xo .X  Xo Xo X.  %.    .X  .@
    o#          %#Xo#@    @#@  X##        @     @ %. Xo  %%o%#   @oo@o Xo X.   @ooX    @Xo@@
    o#          ##  ##    .##. ##X                         . X%   .             ..    .  .
    o#         .##  @#X    %#%%#@                             .
    o#         %#%  o##     ####.
    o#         ##X  o##     X##@                                         .     .
    o#        o########X    @###            X@@X                                                  #.   .%
    o#        %##@@@@@##   o##@#%          @@..@@    %@                  #.
    o#        ##.     ##   ##o ##.         #X   X   .@#o    X   X     XXo#.    X     o%X
    o#       o##      ##X %##  @#@         %#o       @#o   .#  o#    %#o@#.   X#    X#o%#.
    o#       X%X      o%% %%.   %%.         o@#%     %@    .#  o#    #o  #.   X#    #o  #%
    o#                                         @#    %@    .#  o#    #.  #.   X#    #.  #@
    o#                                     @   o#    %@     #  o#    #o  #.   X#    #o  #%
    o#                                     %@oo@@    X#o    #%o@#    @o%#.   X#    X#o%#.
    o#                        #.            .X%o      XX    .%o X     XX.X     X     o%X
    o#.                      .#.
    .##########################



    We're an open source web developer using Laravel Frameworks and HTML5 Technologies.
    Bussiness Inquiries
    axquired24@gmail.com (Gmail)
    +62 896 3144 6027 (Whatsapp)
  -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @stack('metacode')
    <?php 
      if(! isset($aum)) {
      // $aum  = App\Models\AumList::find(1);
      }
    ?>
    <title>@yield('title') - Portal PCM Kartasura </title>

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
        a.noUnderline:hover {
            text-decoration: none;
        }

        .opacity-cl {
            background-color: rgba(0,48,86,0.6);
        }
        .opacity-cl:hover {
            background-color: rgba(0,48,86,0.2);
        }

        /*Remove space between row > col-*/
        .row.no-gutter [class*='col-']:not(:first-child),
        .row.no-gutter [class*='col-']:not(:last-child){
          padding-right: 0;
          padding-left: 0;
        }
        .row.no-gutter {
          margin-right: 0;
          margin-left: 0;
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

        .bg-pcm {
            background-color: #003056;
        }

        .text-pcm {
          color: #003056
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
    @stack('modalcode')

    {{-- js --}}
    <script type="text/javascript" src="{{ URL::asset('assets/js/jquery-1.12.0.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/js/tether.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript">
      $(function () {
        $('[data-toggle="tooltip"]').tooltip();
        $('[data-toggle="tooltip"]').css({'cursor':'pointer'});
      })
    </script>
    @stack('jscode')
</body>
</html>


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

<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
{{--     <link rel="icon" href="../../favicon.ico"> --}}

    <title>@yield('title') | PCM Kartasura Integrated System</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="{{ URL::asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/font-awesome/font-awesome.css') }}">

    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="{{ URL::asset('assets/datatable/jquery.dataTables.min.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('assets/css/offcanvas.css') }}">
    <style>
      .bg-dark {
        background-color: #263238;
      }
      .btn-dark {
        background-color: #263238;
        color: white;
      }
      .btn-dark:hover {
        background-color: #0E475D; /*darker*/
        color: white;
      }
      .btn-outline-dark {
        border-color: #263238;
        background-color: white;
        color: #263238;
      }
      .btn-outline-dark:hover {
        background-color: #263238;
        color: white;
      }
    </style>
    @stack('csscode')
  </head>

  <body>
    <?php
      $user_level   = Auth::user()->level;
      $aum = App\Models\AumList::find(Auth::user()->aum_list_id);
      if($user_level=='admin'){
        $bgclass  = 'danger';
      }
      else if($user_level=='staff') {
        $bgclass  = 'primary';
      }
      else {
        $bgclass   = 'dark';
      }
    ?>
    <nav class="navbar navbar-fixed-top navbar-dark bg-{{ $bgclass }}">
      <div class="container">
        <a href="javascript:undefined" class="navbar-brand hidden-sm-up" data-toggle="offcanvas"><span id="nav-fa" class="fa fa-navicon"></span></a>
        <a class="navbar-brand" href="{{ url('admin') }}"><span class="fa fa-institution hidden-sm-down"></span> Halaman {{ ucfirst($user_level) }} </a>
        <ul class="nav navbar-nav float-xs-right">
          <li class="nav-item active"><a onclick="return confirm('Logout dari halaman?')" class="nav-link" href="{{ url('logout') }}"><span class="fa fa-sign-out"></span> <span class="hidden-sm-down">Logout</span> </a></li>
        </ul>
      </div><!-- /.container -->
    </nav><!-- /.navbar -->

    <div class="container">

      <div class="row row-offcanvas row-offcanvas-left">

        <div class="col-xs-12 col-sm-4 sidebar-offcanvas" id="sidebar">
          <div class="card">
            @if($aum->header_path != '')
            <img class="card-img-top img-fluid w-100" src="{{ URL::asset('files/header/'.$aum->id.'/'.$aum->header_path) }}" alt="{{ $aum->name }}">
            @else
            <img class="card-img-top img-fluid w-100" src="{{ URL::asset('files/default/header.jpg') }}" alt="{{ $aum->name }}">
            @endif

            @if((Auth::user()->level == 'admin') || (Auth::user()->level == 'staff'))
            <div class="card-block">
              <h4 class="card-title">{{ $aum->name }}</h4>
              <p class="card-text">{{ $aum->address }}</p>
              <?php
                if($aum->id == '1')
                {
                  $preview_link = url('/');
                }
                else
                {
                  $preview_link = url('aum/'.$aum->seo_name.'/home');
                }
              ?>
              <a href="{{ $preview_link }}" target="_blank" class="card-link btn btn-outline-{{ $bgclass }}"><span class="fa fa-external-link"></span> Preview </a>
              <div class="hidden-lg-up"><br></div>
              <a href="{{ url('admin/kelola/aum/editSelf/'.$aum->id) }}" class="card-link btn btn-{{ $bgclass }}"><span class="fa fa-edit"></span> Ubah Info</a>
            </div>
            @else
            <div class="card-block">
              <h4 class="card-title">Selamat Datang Kontributor</h4>
              <div class="card-text">Halaman ini digunakan untuk mengirim tulisan kepada seluruh sub situs yang ada dalam sistem website terintegrasi PCM Kartasura.</div>
            </div>
            @endif

            <ul class="list-group list-group-flush">
              <li class="list-group-item bg-{{ $bgclass }} text-white">{{ Auth::user()->name }} (<a class="font-weight-bold text-white" href="{{ url('admin/kelola/pengguna/edit/'.Auth::user()->id) }}">ubah</a>)</li>

              @if($user_level == 'admin')
              <?php 
                $user_nonaktif_count  = App\User::where('is_active',0)->count();
              ?>
              <li class="list-group-item"><a href="{{ url('admin/kelola/pengguna') }}" class="card-link"><span class="fa fa-group"></span>&nbsp; Pengguna Aktif</a>&nbsp;<a href="{{ url('admin/kelola/pengguna/nonaktif') }}" class="text-danger"><small>nonaktif ({{ $user_nonaktif_count }})</small></a></li>
              <li class="list-group-item"><a href="{{ url('admin/kelola/aum') }}" class="card-link"><span class="fa fa-sitemap"></span>&nbsp; Sub Situs</a></li>
              <li class="list-group-item bg-{{ $bgclass }} text-white font-weight-bold">Konten Situs</li>
              @endif

              <li class="list-group-item">
                @if($user_level == 'staff' || $user_level == 'admin')
                <a href="{{ url('admin/kelola/artikel') }}" class="card-link"><span class="fa fa-newspaper-o"></span>&nbsp; Artikel</a>
                <br>
                <small><a href="{{ url('admin/artikel/kategori') }}" class="card-link"><span class="fa fa-tags"></span> Kategori</a></small>
                <br>

                  @if(Auth::user()->aum_list_id == '1')
                  <small><a href="{{ url('admin/kelola/castartikel') }}" class="card-link"><span class="fa fa-paper-plane"></span> Broadcast</a></small>
                  <br>
                  @endif

                  <?php
                  $aum_id   = $aum->id;
                  $belum_terbit_count = App\Models\Article::join('users', 'articles.user_id', '=', 'users.id')
                    ->join('article_categories', 'articles.article_category_id', '=', 'article_categories.id')
                    ->where([
                            ['articles.is_active',0],
                            ['article_categories.name', '!=', 'Pengumuman'],
                            ['article_categories.aum_list_id', $aum_id],
                    ])->count();
                  ?>
                  <small><a href="{{ url('admin/kelola/artikel/nonaktif') }}" class="card-link text-danger"><span class="fa fa-newspaper-o"></span> Belum Terbit ({{ $belum_terbit_count }})</a></small>

                @else
                <a href="{{ url('admin') }}" class="card-link"><span class="fa fa-newspaper-o"></span>&nbsp; Artikel</a>
                @endif

              </li>

              @if($user_level == 'staff' || $user_level == 'admin')
              <li class="list-group-item"><a href="{{ url('admin/kelola/artikel/pengumuman') }}" class="card-link"><span class="fa fa-warning"></span>&nbsp; Pengumuman</a></li>
              <li class="list-group-item"><a href="{{ url('admin/halaman') }}" class="card-link"><span class="fa fa-file-text"></span>&nbsp; Kustom Halaman</a></li>
              <li class="list-group-item"><a href="{{ url('admin/galeri/kategori') }}" class="card-link"><span class="fa fa-image"></span>&nbsp; Galeri</a></li>
              <li class="list-group-item"><a href="{{ url('admin/file') }}" class="card-link"><span class="fa fa-upload"></span>&nbsp; Upload Files</a></li>

              <li class="list-group-item bg-{{ $bgclass }} text-white font-weight-bold">Tampilan</li>
              <li class="list-group-item"><a href="{{ url('admin/kelola/aum/setheader') }}" class="card-link"><span class="fa fa-desktop"></span>&nbsp; Header Situs</a></li>
              <li class="list-group-item"><a href="{{ url('admin/menu') }}" class="card-link"><span class="fa fa-columns"></span>&nbsp; Peletakan Menu</a>&nbsp;<a href="{{ url('admin/menu/dtable') }}" class=""><small>(Tabel Menu)</small></a></li></li>
              @endif

            </ul>
            <div class="card-block bg-{{ $bgclass }}">
              <span class="text-white"><span class="fa fa-bug"></span> Ada Masalah? </span><a href="mailto:axquired24@gmail.com" class="text-white">Laporkan</a>
            </div>
          </div>
        </div><!--/span-->

        <div class="col-xs-12 col-sm-8">

          @if(Session::get('success') !== null)
          <div class="alert alert-info"> {!! Session::get('success') !!}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          @endif

          @yield('content')
        </div><!--/span-->

      </div><!--/row-->

      <hr>

      <footer>
        <p>&copy; Cabang Muhammadiyah Kartasura 2016 - Developed by AxQuired24</p>
      </footer>

    </div><!--/.container-->

    @stack('modalcode')


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="{{ URL::asset('assets/js/jquery-1.12.0.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/js/tether.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/datatable/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/js/offcanvas.js') }}"></script>
    @stack('jscode')
  </body>
</html>

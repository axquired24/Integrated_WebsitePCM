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
    @stack('csscode')
  </head>

  <body>
    <nav class="navbar navbar-fixed-top navbar-dark bg-primary">
      <div class="container">
        <a href="javascript:undefined" class="navbar-brand hidden-sm-up" data-toggle="offcanvas"><span id="nav-fa" class="fa fa-navicon"></span></a>
        <a class="navbar-brand" href="{{ url('admin') }}"><span class="fa fa-institution hidden-sm-down"></span> Halaman Admin </a>
        <ul class="nav navbar-nav float-xs-right">
          <li class="nav-item active"><a class="nav-link" href="{{ url('logout') }}"><span class="fa fa-sign-out"></span> <span class="hidden-sm-down">Logout</span> </a></li>
        </ul>
      </div><!-- /.container -->
    </nav><!-- /.navbar -->

    <div class="container">

      <div class="row row-offcanvas row-offcanvas-left">

        <div class="col-xs-12 col-sm-4 sidebar-offcanvas" id="sidebar">
          <div class="card">
            <img class="card-img-top img-fluid w-100" src="{{ URL::asset('images/sekolah/sample/slidePCMKTS.jpg') }}" alt="Card image cap">
            <div class="card-block">
              <h4 class="card-title">Pimpinan Cabang Muhammadiyah Kartasura</h4>
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
              <a href="#" class="card-link btn btn-outline-primary"><span class="fa fa-external-link"></span> Preview </a>
              <div class="hidden-lg-up"><br></div>
              <a href="#" class="card-link btn btn-primary"><span class="fa fa-edit"></span> Ubah Info</a>
            </div>
            <ul class="list-group list-group-flush">
              <li class="list-group-item">Albert Septiawan (<a class="card-link" href="#">ubah</a>)</li>
              {{-- <li class="list-group-item"><a href="#" class="card-link"><span class="fa fa-line-chart"></span>&nbsp; Statistik Sub Situs</a></li> --}}
              <li class="list-group-item"><a href="{{ url('admin/kelola/pengguna') }}" class="card-link"><span class="fa fa-group"></span>&nbsp; Kelola Pengguna</a></li>
              <li class="list-group-item"><a href="{{ url('admin/kelola/pengguna/nonaktif') }}" class="card-link text-danger"><span class="fa fa-user"></span>&nbsp; Pengguna belum diverifikasi</a></li>
              <li class="list-group-item"><a href="{{ url('admin/kelola/aum') }}" class="card-link"><span class="fa fa-sitemap"></span>&nbsp; Sub Situs</a></li>
              <li class="list-group-item active font-weight-bold">Konten Situs</li>
              <li class="list-group-item"><a href="#" class="card-link"><span class="fa fa-newspaper-o"></span>&nbsp; Artikel</a></li>
              <li class="list-group-item"><a href="#" class="card-link text-danger"><span class="fa fa-newspaper-o"></span>&nbsp; Artikel belum diverifikasi</a></li>
              <li class="list-group-item"><a href="#" class="card-link"><span class="fa fa-file-text"></span>&nbsp; Kustom Halaman</a></li>
              <li class="list-group-item"><a href="#" class="card-link"><span class="fa fa-image"></span>&nbsp; Galeri</a></li>
              <li class="list-group-item"><a href="#" class="card-link"><span class="fa fa-upload"></span>&nbsp; Upload Files</a></li>
              <li class="list-group-item"><a href="#" class="card-link text-danger"><span class="fa fa-paper-plane"></span>&nbsp; Broadcast Artikel</a></li>
              <li class="list-group-item active font-weight-bold">Tampilan</li>
              <li class="list-group-item"><a href="#" class="card-link"><span class="fa fa-desktop"></span>&nbsp; Header Situs</a></li>
              <li class="list-group-item"><a href="#" class="card-link"><span class="fa fa-columns"></span>&nbsp; Peletakan Menu</a></li>
            </ul>
            <div class="card-block bg-primary">
              <span class="text-white"><span class="fa fa-bug"></span> Ada Masalah? </span><a href="#" class="text-white">Laporkan</a>
            </div>
          </div>
        </div><!--/span-->

        <div class="col-xs-12 col-sm-8">
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
    <script type="text/javascript" src="{{ URL::asset('assets/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/datatable/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/js/offcanvas.js') }}"></script>
    @stack('jscode')
  </body>
</html>

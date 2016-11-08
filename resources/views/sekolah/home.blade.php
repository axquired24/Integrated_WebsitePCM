@extends('layouts.sekolah')

@section('title', 'SMA Muhammadiyah 4 Kartasura')
@section('title_cap', 'Home')
@section('content')
@push('csscode')
    <style>
        a.noUnderline:hover {
            text-decoration: none;
        }

        .opacity-cl {
            background-color: rgba(254,0,0,0.3);
        }
        .opacity-cl:hover {
            background-color: rgba(0,0,0,0.2);
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
    </style>
@endpush
{{-- header --}}
<div class="container-fluid">
  <div class="row">
    <div class="card card-inverse">
      <img class="card-img img-fluid w-100" src="{{ URL::asset('images/sekolah/sample/Desert.jpg') }}" alt="Carousel" style="border-radius:0px;height:100vh;">
      <div class="card-img-overlay" style="background-color: rgba(0,0,0,0.4);">
        <div align="center">
        <h2 class="card-title d-inline-block" style="margin-top: 55vh; background-color: rgba(254,0,0,1); padding: 5px 10px; border-radius:5px;">SMA Muhammadiyah 4 Kartasura</h2>
        <h5 class="card-text text-xs-center text-white">Galeri caption terlihat disini.</h5>
        </div>
      </div>
    </div> {{-- card-top --}}
  </div>
</div>
<br>
<div class="hidden-xs-up">
    <br><br>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-5 col-xs-10">
            <h2><span class="fa fa-newspaper-o"></span>&nbsp; Berita Terbaru</h2>
        </div>
        <div class="col-md-7 col-xs-2">
            <form class="form-inline pull-right">
              <div class="form-group hidden-sm-down">
                <label for="filterKabar">Filter</label>
                <select class="custom-select">
                  <option selected>Filter berdasarkan</option>
                  <option value="1">One</option>
                  <option value="2">Two</option>
                  <option value="3">Three</option>
                </select>
              </div>
              <button class="btn btn-outline-danger"><span class="fa fa-search"></span></button>
            </form>
        </div>
    </div>{{-- row --}}
    <hr>
    <div class="row">
        <div class="col-lg-8 col-md-7">
            <ul class="media-list">
                @for($i=1; $i<9; $i++)
                <li class="media mb-1">
                <div class="card px-1 py-1 my-0">
                  <div class="media-body">
                    <h6 class="media-heading"><a class="noUnderline" href="#">PCM Kartasura akan mengadakan pertemuan terkait diselenggarakannya...</a></h6>
                    Pertemuan besar yang diikuti oleh seluruh masyarakat Kartasura tersebut akan dilaksanakan pada ... <br>
                    <div class="clear-fix">
                    <span class="tag tag-success">Berita</span> &nbsp;
                    <small class="card-subtitle text-muted">
                        <span class="fa fa-calendar-o"></span>&nbsp; 24 September 2015 &nbsp;
                        <span class="fa fa-user"></span>&nbsp; Albert Septiawan
                    </small>
                    </div>
                  </div>
                  <a class="media-right" href="#">
                    <img class="media-object" src="{{ URL::asset('images/sekolah/sample/Desert.jpg') }}" width="128px" alt="Generic placeholder image">
                  </a>
                  </div>
                </li> {{-- media --}}
                @endfor

              <div align="center" class="row"> {{-- Pagination --}}
                  <nav aria-label="Page navigation">
                    <ul class="pagination">
                      <li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">
                          <span aria-hidden="true">&laquo;</span>
                          <span class="sr-only">Previous</span>
                        </a>
                      </li>
                      <li class="page-item active"><a class="page-link" href="#">1</a></li>
                      <li class="page-item"><a class="page-link" href="#">2</a></li>
                      <li class="page-item"><a class="page-link" href="#">3</a></li>
                      <li class="page-item"><a class="page-link" href="#">4</a></li>
                      <li class="page-item"><a class="page-link" href="#">5</a></li>
                      <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                          <span aria-hidden="true">&raquo;</span>
                          <span class="sr-only">Next</span>
                        </a>
                      </li>
                    </ul>
                  </nav>
              </div> {{-- row pagination --}}

            </ul> {{-- media-list --}}
        </div>
        {{-- col-md-left --}}

        <div class="col-lg-4 col-md-5">
            {{-- Galeri Foto --}}
            <div class="card mb-0">
              <div class="card-header" style="background-color:#FFF; border-bottom: none; margin-bottom: -2px;">
                Galeri Foto
              </div>
            </div>
            <div class="card card-inverse mb-0" style="border-bottom: rgba(254,0,0,1) 4px solid; border-radius:0;">
              <img class="card-img img-fluid w-100" src="{{ URL::asset('images/sekolah/sample/Koala.jpg') }}" alt="Card image" style="border-radius:0px;">
              <div class="card-img-overlay opacity-cl">
                <h4 class="card-title"><span class="fa fa-camera float-xs-right"></span></h4>
                <br><br><br><br>
                <p class="card-text text-xs-center"><a href="#" class="btn btn-sm btn-danger">Galeri Kategori</a></p>
                <p class="card-text text-xs-center text-white">Pelantikan siswa baru.</p>
              </div>
            </div> {{-- card-top --}}

            <div class="row no-gutter">
                <div class="col-xs-3"><img class="card-img img-fluid" src="{{ URL::asset('images/sekolah/sample/Penguins.jpg') }}" alt="Card image" style="border-radius:0px;"></div>
                <div class="col-xs-3"><img class="card-img img-fluid" src="{{ URL::asset('images/sekolah/sample/Koala.jpg') }}" alt="Card image" style="border-radius:0px;"></div>
                <div class="col-xs-3"><img class="card-img img-fluid" src="{{ URL::asset('images/sekolah/sample/Hydrangeas.jpg') }}" alt="Card image" style="border-radius:0px;"></div>
                <div class="col-xs-3"><img class="card-img img-fluid" src="{{ URL::asset('images/sekolah/sample/Koala.jpg') }}" alt="Card image" style="border-radius:0px;"></div>
            </div>
            {{-- End Galeri Foto --}}

            <br>
            {{-- Pengumuman --}}
            <div class="card">
              <div class="card-header text-white font-weight-bold" style="background-color: rgba(254,0,0,1);">
                PENGUMUMAN
              </div>
              <div class="card-block">
                <ul class="media-list">
                  @for($i=1; $i<4; $i++)
                  <li class="media mb-1">
                    <a class="media-left" href="#">
                      <img class="media-object" src="{{ URL::asset('images/sekolah/sample/Desert.jpg') }}" width="64px" alt="Generic placeholder image">
                    </a>
                    <div class="media-body">
                      <h6 class="media-heading"><a class="noUnderline" href="#">Pengambilan Beasiswa 2016</a></h6>
                      <small class="card-subtitle">
                          <span class="text-muted">24 September 2015</span> <br>
                          <a style="color:red; font-weight:bold" href="#">SELENGKAPNYA</a>
                      </small>
                    </div>
                  </li> {{-- media --}}
                  @endfor
                  <div align="center" class="mb-0"><a href="javascript:undefined" class="btn btn-sm btn-danger"><span class="fa fa-chevron-left"></span> </a> &nbsp; <a href="javascript:undefined" class="btn btn-sm btn-danger"><span class="fa fa-chevron-right"></span></a></div>
                </ul> {{-- media-list --}}
              </div>
            </div>
            {{-- END Pengumuman --}}

            <br>
            {{-- Download --}}
            <div class="card">
              <div class="card-header text-white font-weight-bold bg-success">
                DOWNLOAD
              </div>
              <div class="card-block">
                <ul class="media-list">
                  @for($i=1; $i<4; $i++)
                  <li class="media">
                    <a class="media-left bg-success px-1 py-1" href="#">
                      {{-- <img class="media-object" src="{{ URL::asset('images/sekolah/sample/Desert.jpg') }}" width="64px" alt="Generic placeholder image"> --}}
                      <h5 class="text-white text-xs-center">
                        <span class="fa fa-download"></span>
                      </h5>
                    </a>
                    <div class="media-body">
                      <h6 class="media-heading mx-1"><a class="noUnderline text-success" href="#">Berkas PSB 2016</a></h6>
                      <small class="card-subtitle mx-1">
                          <span class="text-muted">24 September 2015</span> <br>
                      </small>
                    </div>
                  </li> {{-- media --}}
                  <hr>
                  @endfor
                  <div align="center" class="mb-0"><a href="javascript:undefined" class="btn btn-sm btn-secondary">Lihat semua</a></div>
                </ul> {{-- media-list --}}
              </div>
            </div>
            {{-- END Download --}}
        </div>
        {{-- col-md-right --}}
    </div> {{-- row --}}
    <br>
    <div class="hidden-xs-up">
        <br><br>
    </div>
</div> {{-- container --}}

<div class="container-fluid" style="background: #FFF;">
  <div class="container">
    <br>
    <div class="row">
      <div align="right" class="col-md-7 col-lg-8">
        <h3 class="d-block bg-sekolah text-white mb-1" style="padding:8px 10px; border-radius:2px;">
          SMA Muhammadiyah 4 Kartasura
        </h3>
        <h6 class="mb-1 text-sekolah">
          <span class="align-text-top"><a href="#">Jl. Raya Jogja-Solo No.1, Kartasura, Kec. Sukoharjo, Jawa Tengah</a></span>
          &nbsp; &nbsp; <span class="fa fa-map-marker text-lg-2 hidden-md-down"></span>
        </h6>
        <h6 class="mb-1 text-sekolah">
          <span class="align-text-top"><a href="#">(0271) 871811</a></span>
          &nbsp; &nbsp; <span class="fa fa-phone text-lg-2 hidden-md-down"></span>
        </h6>
        <h6 class="mb-1 text-sekolah">
          <span class="align-text-top font-weight-bold"><a href="#">Lihat Profil Lengkap</a></span>
          &nbsp; &nbsp; <span class="fa fa-building text-lg-2 hidden-md-down"></span>
        </h6>
        <h6 class="mb-1 text-sekolah">
          <span class="align-text-top"><a href="#">Penerimaan Siswa Baru</a></span>
          &nbsp; &nbsp; <span class="fa fa-users text-lg-2 hidden-md-down"></span>
        </h6>
        <h6 class="mb-1 text-sekolah">
          <span class="align-text-top"><a href="#">Prestasi</a></span>
          &nbsp; &nbsp; <span class="fa fa-line-chart text-lg-2 hidden-md-down"></span>
        </h6>
        <h6 class="mb-1 text-sekolah">
          <span class="align-text-top"><a href="#">Galeri Foto</a></span>
          &nbsp; &nbsp; <span class="fa fa-camera text-lg-2 hidden-md-down"></span>
        </h6>
      </div>
      <div class="col-md-5 col-lg-4">
        <img class="img-thumbnail img-fluid w-100" src="{{ URL::asset('images/sekolah/sample/Tulips.jpg') }}" alt="Carousel" style="border-radius:0px;height:300px;">
      </div>
    </div>
    <br>
  </div>
</div> {{-- container-fluid --}}
@endsection

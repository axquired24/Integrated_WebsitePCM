@extends('layouts.app')

@section('content')
@push('csscode')
    <style>
        body{
            padding-top: 50px;
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
    </style>
@endpush
<?php 
  $aum  = App\Models\AumList::find('1');  
?>
<div id="carouselHeader" class="carousel slide" data-ride="carousel">
  <div class="carousel-inner" role="listbox">
    <div class="carousel-item active">
      <img class="w-100" style="height:75vh" src="{{ URL::asset('files/header/'.$aum->id.'/'.$aum->header_path) }}" alt="{{ $aum->name }}">
      <div class="carousel-caption">
          <h3 class="d-inline bg-danger">&nbsp; {{ $aum->name }} &nbsp;</h3>
      </div> {{-- carousel-caption --}}
    </div> {{-- carousel-item --}}
  </div> {{-- carousel-inner --}}
</div> {{-- id="carouselHeader" --}}
<nav class="navbar navbar-dark navbar-full" style="background-color: #003056">&nbsp;</nav>
<br>
<div class="hidden-xs-up">
    <br><br>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-5">
            <div class="card card-inverse">
              <img class="card-img img-fluid w-100" src="{{ URL::asset('images/sekolah/sample/Koala.jpg') }}" alt="Card image" style="border-radius:0px;">
              <div class="card-img-overlay opacity-cl">
                <h4 class="card-title"><span class="fa fa-camera"></span></h4>
                <br><br>
                <p class="card-text text-xs-center text-white">Galeri caption terlihat disini.</p>
                <p class="card-text text-xs-center"><a href="#" class="btn btn-sm btn-primary">Galeri Kategori</a></p>
              </div>
            </div> {{-- card-top --}}

            <div class="row no-gutter">
                <div class="col-xs-3"><img class="card-img img-fluid" src="{{ URL::asset('images/sekolah/sample/Koala.jpg') }}" alt="Card image" style="border-radius:0px;"></div>
                <div class="col-xs-3"><img class="card-img img-fluid" src="{{ URL::asset('images/sekolah/sample/Penguins.jpg') }}" alt="Card image" style="border-radius:0px;"></div>
                <div class="col-xs-3"><img class="card-img img-fluid" src="{{ URL::asset('images/sekolah/sample/Koala.jpg') }}" alt="Card image" style="border-radius:0px;"></div>
                <div class="col-xs-3"><img class="card-img img-fluid" src="{{ URL::asset('images/sekolah/sample/Penguins.jpg') }}" alt="Card image" style="border-radius:0px;"></div>
            </div>
        </div>
        {{-- col-md-left --}}
        <div class="col-md-7">
            <div class="hidden-sm-up">
                <hr>
            </div>
            <h2>Informasi & Pengumuman <span class="fa fa-bar-chart pull-right hidden-sm-down"></span></h2>
            <hr>
            <ul class="media-list">
                @for($i=1; $i<5; $i++)
                <li class="media">
                  <a class="media-left" href="#">
                    <img class="media-object" src="{{ URL::asset('images/sekolah/sample/Desert.jpg') }}" width="128px" alt="Generic placeholder image">
                  </a>
                  <div class="media-body">
                    <h5 class="media-heading"><a class="noUnderline" href="#">PCM Kartasura akan mengadakan pertemuan terkait diselenggarakannya...</a></h5>
                    Pertemuan tersebut akan dilaksanakan pada ... <br>
                    <span class="tag tag-danger">Pengumuman</span> &nbsp; <span class="text-muted">24 SEPTEMBER 2015</span>
                  </div>
                </li> {{-- media --}}
                <br>
                @endfor
                <div align="center"><a href="javascript:undefined" class="btn btn-sm btn-primary"><span class="fa fa-chevron-left"></span> Sebelumnya</a> &nbsp; <a href="javascript:undefined" class="btn btn-sm btn-primary">Selanjutnya <span class="fa fa-chevron-right"></span></a></div>
            </ul> {{-- media-list --}}
        </div>
        {{-- col-md-right --}}
    </div> {{-- row --}}
    <br>
    <div class="hidden-xs-up">
        <br><br>
    </div>
    <div class="row">
        <div class="col-md-5 col-xs-10">
            <h2><span class="fa fa-newspaper-o"></span>&nbsp; Kabar Terbaru</h2>
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
              <button class="btn btn-outline-primary"><span class="fa fa-search"></span></button>
            </form>
        </div>
    </div>{{-- row --}}
    <hr>
    <div class="row">
        @for($i=1; $i<6; $i++)
        <div class="col-md-4">
            <div class="card">
              <div class="card-block">
                <h4 class="card-title">PCM Kartasura sediakan hidangan berbuka bersama</h4>
                <small class="card-subtitle text-muted">
                    <span class="fa fa-calendar-o"></span>&nbsp; 24 September 2015
                    <span class="pull-right"><span class="fa fa-user"></span>&nbsp; Albert Septiawan</span>
                </small>
              </div>
              <img class="img-fluid" src="{{ URL::asset('images/sekolah/sample/Penguins.jpg') }}" alt="Card image">
              <div class="card-block">
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.. <a href="#" class="noUnderline font-weight-bold">#Kategori Berita</a></p>
                <a href="#" class="btn btn-primary card-link">Baca selengkapnya</a>
                <a href="#" class="btn btn-outline-primary card-link">Share</a>
              </div>
            </div>
        </div>
        @endfor       
    </div>{{-- row --}}

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
    </div> {{-- row --}}    
</div> {{-- container --}}
@endsection

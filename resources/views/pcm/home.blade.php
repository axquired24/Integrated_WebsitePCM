@extends('layouts.pcm_home')
@section('title', 'Home')
@section('content')
@push('csscode')
  <style>
    body{
      padding-top: 50px;
    }
  </style>
@endpush

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
              <img style="height:65vh" class="card-img img-fluid w-100" src="{{ URL::asset('files/galeri/'.$aum->id.'/'.$random_galeri->filename) }}" alt="Galeri {{ $aum->name }}" style="border-radius:0px;">
              <div class="card-img-overlay opacity-cl">
                <h4 class="card-title"><span class="fa fa-camera"></span></h4>
                <br><br>
                <p class="card-text text-xs-center lead text-white">Galeri {{ $random_galeri->galleryCategory->name }}</p>
                <p class="card-text text-xs-center"><a href="{{ url('galerikategori/'.$random_galeri->galleryCategory->id) }}" class="btn btn-sm btn-primary">Lihat Galeri</a></p>
              </div>
            </div> {{-- card-top --}}

            <div class="row no-gutter">
                <?php $galeri_no   = 0; ?>
                @foreach($galeris as $galeri)
                <?php $galeri_no ++; ?>
                <div class="col-xs-3">
                  @if($galeri_no == 4)
                      <div align="center" class="card card-inverse">
                        <img style="max-height:100px;" class="card-img w-100 img-fluid" src="{{ URL::asset('files/galeri/'.$aum->id.'/thumb-'.$galeri->filename) }}" alt="Galeri {{ $aum->name }}" style="border-radius:0px;">
                        <div class="card-img-overlay opacity-cl">
                          <br class="hidden-md-down">
                          <a href="{{ url('galeri') }}" class="text-white"  data-toggle="tooltip" data-placement="top" title="Lihat Semua Galeri"><span class="fa fa-chevron-right"></span><span class="fa fa-chevron-right"></span></a>
                        </div>
                      </div> {{-- card-top --}}
                  @else
                      <img class="card-img img-fluid" src="{{ URL::asset('files/galeri/'.$aum->id.'/thumb-'.$galeri->filename) }}" alt="Galeri {{ $aum->name }}" style="border-radius:0px;" data-toggle="tooltip" data-placement="top" title="Galeri {{ $galeri->galleryCategory->name }}">
                  @endif
                </div> {{-- col-xs-3 --}}
                @endforeach
            </div> {{-- no-gutter --}}
        </div>
        {{-- col-md-left --}}

        <div class="col-md-7">
            <div class="hidden-sm-up">
                <hr>
            </div>
            <h2>Informasi & Pengumuman <span class="fa fa-bar-chart pull-right hidden-sm-down"></span></h2>
            <hr>
            <form action="#">
                <input type="hidden" id="currentPageForm">
                <input type="hidden" id="nextPageForm">
            </form>
            <ul class="media-list" id="pengumuman-widget">
                @if(count($pengumumans) > 0)
                @foreach($pengumumans as $pengumuman)
                <li class="media">
                  <a class="media-left" href="{{ url('artikel/'.$pengumuman->id) }}">
                    <img class="media-object" src="{{ URL::asset('files/artikel/'.$aum->id.'/'.$pengumuman->image_path) }}" width="128px" height="100px" alt="Gambar : {{ $pengumuman->title }}">
                  </a>
                  <div class="media-body">
                    <h5 class="media-heading"><a class="card-link" href="{{ url('artikel/'.$pengumuman->id) }}">{{ str_limit($pengumuman->title, 40) }}</a></h5>
                    {!! str_limit(strip_tags($pengumuman->content), 130) !!}<br>
                    <span class="tag tag-danger">Pengumuman</span> &nbsp; <span class="text-muted">{{ date_format($pengumuman->updated_at, 'd F Y') }}</span>
                  </div>
                  <br>
                </li> {{-- media --}}
                @endforeach
                <div align="center"><a id="prevPengumumanBtn" href="javascript:prevPengumuman()" class="btn btn-sm btn-primary"><span class="fa fa-chevron-left"></span> Selanjutnya</a> &nbsp; <a id="nextPengumumanBtn" href="javascript:nextPengumuman()" class="btn btn-sm btn-primary">Sebelumnya <span class="fa fa-chevron-right"></span></a></div>                
                @else
                <li class="media">
                  <div class="media-body">
                    <h5 class="media-heading"><a class="noUnderline" href="#">Pengumuman belum tersedia</a></h5>
                    Informasi terkait hal penting akan ditunjukkan dalam sisi ini.<br>
                    <span class="tag tag-danger">Pengumuman</span> &nbsp; <span class="text-muted">-</span>
                  </div>
                  <br>
                @endif {{-- EOF IF $pengumuman > 0 --}}

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
                <select class="custom-select" onchange="filterKategori(this)" id="filterForm">
                  <option value="" selected>Pilih kategori</option>
                  @foreach($non_pengumuman_kategoris as $filter)
                  <option value="{{ $filter->id }}">{{ $filter->name }}</option>
                  @endforeach
                </select>
              </div>
              <button type="button" class="btn btn-outline-primary" onclick="cariArtikel()"><span class="fa fa-search"></span></button>
            </form>
        </div>
    </div>{{-- row --}}
    <hr>
    <div class="row">
        @foreach($beritas as $berita)
        <div class="col-md-4">
            <div class="card">
              <div class="card-block" style="min-height:130px">
                <h4 class="card-title"><a href="{{ url('artikel/'.$berita->id) }}" class="card-link">{{ str_limit($berita->title, 40) }}</a></h4>
                <small class="card-subtitle text-muted">
                    <span class="fa fa-calendar-o"></span>&nbsp; {{ date_format($berita->updated_at, 'd F Y') }}
                    <span class="pull-right"><span class="fa fa-user"></span>&nbsp; {{ $berita->user->name }}</span>
                </small>
              </div>
              <img class="w-100" src="{{ URL::asset('files/artikel/'.$aum->id.'/'.$berita->image_path) }}" alt="Gambar Berita : {{ $berita->title }}" height="250px">
              <div class="card-block" style="min-height:200px">
                <p class="card-text">{!! str_limit(strip_tags($berita->content), 130) !!}<a href="#" class="noUnderline font-weight-bold"></a></p>
                <a href="{{ url('artikelkategori/'.$berita->articleCategory->id) }}" class="btn btn-outline-danger card-link">#{{ $berita->articleCategory->name }}</a>
                <a href="{{ url('artikel/'.$berita->id) }}" class="btn btn-primary card-link">Selengkapnya</a>
              </div>
            </div>
        </div>
        @endforeach        
    </div>{{-- row --}}

    <div align="center" class="row"> {{-- Pagination --}}
        <nav aria-label="Page navigation">
          @include('layouts.pagination', ['paginator' => $beritas])
        </nav>
    </div> {{-- row --}}
</div> {{-- container --}}

@push('modalcode')
<div class="modal fade loading-pengumuman" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">Loading</h4>
      </div>
      <div class="modal-body">Harap Tunggu ... </div>
    </div>
  </div>
</div>
@endpush

@push('jscode')
  <script type="text/javascript">
    $(document).ready(function() {
      $('#prevPengumumanBtn').hide();
      $('#currentPageForm').val('1');
      $('#nextPageForm').val('2');
    });

    function cariArtikel () {
      var cari  = prompt('Cari berita: ');
    }

    function filterKategori (filterForm) {
      var filterVal   = filterForm.value;
      // $('#filterForm').val(filterVal);
      if(filterVal != '') {
        // alert(filterVal);
        document.location = '{{ url("artikelkategori") }}' + '/' + filterVal;
      }
    }

    // For Older Pengumuman
    function nextPengumuman() {
      var currentPage = parseInt($('#currentPageForm').val());
      var nextPage    = parseInt($('#nextPageForm').val());
      $('.loading-pengumuman').modal('show');

      $.ajax({
          method: 'POST',
          url: '{{ url("artikel/ajax/nextpengumuman") }}',
          beforeSend: function (xhr) {
            return xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
          },
          data: {
            next_page   : nextPage,
            current_page  : currentPage,
           },
          // dataType: 'json',
          success:function(data){
            $('#pengumuman-widget').html(data);
            $('#currentPageForm').val(nextPage);
            $('#nextPageForm').val(nextPage+1);
            var acuan   = $('#currentPageForm').val();
            if(acuan >= {{ $total_pengumuman }})
            {
              $('#nextPengumumanBtn').hide();
            }
            $('.loading-pengumuman').modal('hide');
              // alert(data);
          },error:function(data){
              alert("Terjadi kesalahan: "+data);
              console.log(data);
          }
      });
    }

    // For Newer Pengumuman
    function prevPengumuman() {
      var currentPage = parseInt($('#currentPageForm').val());
      var nextPage    = currentPage - 1;
      $('.loading-pengumuman').modal('show');

      $.ajax({
          method: 'POST',
          url: '{{ url("artikel/ajax/nextpengumuman") }}',
          beforeSend: function (xhr) {
            return xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
          },
          data: {
            next_page   : nextPage,
            current_page  : currentPage,
           },
          // dataType: 'json',
          success:function(data){
            $('#pengumuman-widget').html(data);
            $('#currentPageForm').val(nextPage);
            $('#nextPageForm').val(nextPage+1);
            var acuan   = $('#currentPageForm').val();
            if(acuan == 1)
            {
              $('#prevPengumumanBtn').hide();
            }
            $('.loading-pengumuman').modal('hide');
          },error:function(data){
              alert("Terjadi kesalahan: "+data);
              console.log(data);
          }
      });
    }
  </script>
@endpush
@endsection

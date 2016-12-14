@extends('layouts.aum_home')

@section('title', 'Home')
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

{{-- {{ dd($beritas) }} --}}
{{-- header --}}
<div class="container-fluid">
  <div class="row">
    <div class="card card-inverse">
      <img class="card-img img-fluid w-100" src="{{ URL::asset('files/header/'.$aum->id.'/'.$aum->header_path) }}" alt="{{ $aum->name }}" style="border-radius:0px;height:100vh;">
      <div class="card-img-overlay" style="background-color: rgba(0,0,0,0.4);">
        <div align="center">
        <h2 class="card-title d-inline-block" style="margin-top: 55vh; background-color: rgba(254,0,0,1); padding: 5px 10px; border-radius:5px;">{{ $aum->name }}</h2>
        <h5 class="card-text text-xs-center text-white">{{ $aum->address }}</h5>
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
                <select class="custom-select" onchange="filterKategori(this)" id="filterForm">
                  <option value="" selected>Pilih kategori</option>
                  @foreach($non_pengumuman_kategoris as $filter)
                  <option value="{{ $filter->id }}">{{ $filter->name }}</option>
                  @endforeach
                </select>
              </div>
              <button type="button" class="btn btn-outline-danger" onclick="cariArtikel()"><span class="fa fa-search"></span></button>
            </form>
        </div>
    </div>{{-- row --}}
    <hr>
    <div class="row">
        <div class="col-lg-8 col-md-7">
            <ul class="media-list">
                @foreach($beritas as $berita)
                <li class="media mb-1">
                <div class="card px-1 py-1 my-0">
                  <div class="media-body">
                    <h6 class="media-heading"><a title="{{ $berita->title }}" class="noUnderline" href="{{ url('aum/'.$aum->seo_name.'/artikel/'.$berita->id) }}">{{ str_limit($berita->title, 70) }}</a></h6>
                    {!! str_limit(strip_tags($berita->content), 140) !!} <br>
                    <div class="clear-fix">
                    @if($berita->articleCategory->aum_list_id == '1')
                      <span data-toggle="tooltip" data-placement="top" title="Berita dari: {{ $berita->articleCategory->aumList->name }}" class="tag tag-warning">{{ $berita->articleCategory->name }}</span> &nbsp;
                    @else
                      <span class="tag tag-success">{{ $berita->articleCategory->name }}</span> &nbsp;
                    @endif                    
                    <small class="card-subtitle text-muted">
                        <span class="fa fa-calendar-o"></span>&nbsp; {{ date_format($berita->updated_at, 'd F Y') }} &nbsp;
                        <span class="fa fa-user"></span>&nbsp; {{ $berita->user->name }}
                    </small>
                    </div>
                  </div>
                  <a class="media-right" href="{{ url('aum/'.$aum->seo_name.'/artikel/'.$berita->id) }}">
                    <img class="media-object" src="{{ URL::asset('files/artikel/'.$berita->articleCategory->aum_list_id.'/thumb-'.$berita->image_path) }}" width="128px" alt="{{ $berita->title . ' - ' . $berita->articleCategory->aumList->name }}">
                  </a>
                  </div>
                </li> {{-- media --}}
                @endforeach

              <div align="center" class="row"> {{-- Pagination --}}
                  <nav aria-label="Page navigation">
                    @include('layouts.pagination', ['paginator' => $beritas])
                  </nav>
              </div> {{-- row --}}

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
              <img class="card-img img-fluid w-100" src="{{ URL::asset('files/galeri/'.$aum->id.'/'.$random_galeri->filename) }}" alt="Galeri {{ $aum->name }}"  style="border-radius:0px; min-height:270px">
              <div class="card-img-overlay opacity-cl">
                <h4 class="card-title"><span class="fa fa-camera float-xs-right"></span></h4>
                <br><br><br><br>
                <p class="card-text text-xs-center"><a href="{{ url('aum/'.$aum->seo_name.'/galeri') }}" class="btn btn-sm btn-danger">Lihat Semua Galeri</a></p>
                <p class="card-text text-xs-center text-white">{{ $random_galeri->galleryCategory->name }}</p>
              </div>
            </div> {{-- card-top --}}

            <div class="row no-gutter">
                <?php $galeri_no   = 0; ?>
                @foreach($galeris as $galeri)
                <?php $galeri_no ++; ?>

                <div class="col-xs-3">
                  <a href="{{ url('aum/'.$aum->seo_name.'/galerikategori/'.$galeri->galleryCategory->id) }}" data-toggle="tooltip" data-placement="top" title="Galeri {{ $galeri->galleryCategory->name }}">
                  <img class="card-img img-fluid" src="{{ URL::asset('files/galeri/'.$aum->id.'/thumb-'.$galeri->filename) }}" alt="Galeri {{ $aum->name }}" style="border-radius:0px;">
                  </a>
                </div>

                @endforeach
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
                  @foreach($pengumumans as $pengumuman)
                  <li class="media mb-1">
                    <a class="media-left" href="{{ url('aum/'.$aum->seo_name.'/artikel/'.$pengumuman->id) }}">
                      <img class="media-object" src="{{ URL::asset('files/artikel/'.$pengumuman->articleCategory->aum_list_id.'/thumb-'.$pengumuman->image_path) }}" width="64px" alt="Generic placeholder image">
                    </a>
                    <div class="media-body">
                      <h6 class="media-heading"><a title="{{ $pengumuman->title }}" class="noUnderline" href="{{ url('aum/'.$aum->seo_name.'/artikel/'.$pengumuman->id) }}">{{ str_limit($pengumuman->title, 23) }}</a></h6>
                      <small class="card-subtitle">
                          <span class="text-muted">{{ date_format($pengumuman->updated_at, 'd F Y') }}</span> <br>
                          <a style="color:red; font-weight:bold" href="{{ url('aum/'.$aum->seo_name.'/artikel/'.$pengumuman->id) }}">SELENGKAPNYA</a>
                      </small>
                    </div>
                  </li> {{-- media --}}
                  @endforeach
                  <div align="center" class="mb-0"><a href="{{ url('aum/'.$aum->seo_name.'/artikelkategori/'.$kategori_pengumuman->id) }}" class="btn btn-sm btn-danger">Lihat Semua </a></div>
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
                  @foreach($daftarFile as $file)
                  <li class="media">
                    <a class="media-left bg-success px-1 py-1" href="{{ url('aum/'.$aum->seo_name.'/file/download/'.$file->id) }}">                      
                      <h5 class="text-white text-xs-center">
                        <span class="fa fa-download"></span>
                      </h5>
                    </a>
                    <div class="media-body">
                      <h6 class="media-heading mx-1"><a title="{{ $file->title }}" class="noUnderline text-success" href="{{ url('aum/'.$aum->seo_name.'/file/download/'.$file->id) }}">{{ str_limit($file->title, 23) }}</a></h6>
                      <small class="card-subtitle mx-1">
                          <span class="text-muted">{{ date_format($file->updated_at, 'd F Y') }}</span> <br>
                      </small>
                    </div>
                  </li> {{-- media --}}
                  <hr>
                  @endforeach
                  <div align="center" class="mb-0"><a href="{{ url('aum/'.$aum->seo_name.'/daftarfile') }}" class="btn btn-sm btn-secondary">Lihat semua</a></div>
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
          {{ $aum->name }}
        </h3>
        <h6 class="mb-1 text-sekolah">
          <span class="align-text-top"><a href="#">{{ $aum->address }}</a></span>
          &nbsp; &nbsp; <span class="fa fa-map-marker text-lg-2 hidden-md-down"></span>
        </h6>
        <h6 class="mb-1 text-sekolah">
          <span class="align-text-top"><a href="#">{{ $aum->contact }}</a></span>
          &nbsp; &nbsp; <span class="fa fa-phone text-lg-2 hidden-md-down"></span>
        </h6>
        <h6 class="mb-1 text-sekolah">
          <span class="align-text-top font-weight-bold"><a href="{{ url('aum/'.$aum->seo_name.'/halaman/'.$profilPage->id) }}">Lihat Profil Lengkap</a></span>
          &nbsp; &nbsp; <span class="fa fa-building text-lg-2 hidden-md-down"></span>
        </h6>
{{--         <h6 class="mb-1 text-sekolah">
          <span class="align-text-top"><a href="#">Penerimaan Siswa Baru</a></span>
          &nbsp; &nbsp; <span class="fa fa-users text-lg-2 hidden-md-down"></span>
        </h6>
        <h6 class="mb-1 text-sekolah">
          <span class="align-text-top"><a href="#">Prestasi</a></span>
          &nbsp; &nbsp; <span class="fa fa-line-chart text-lg-2 hidden-md-down"></span>
        </h6> --}}
        <h6 class="mb-1 text-sekolah">
          <span class="align-text-top"><a href="{{ url('aum/'.$aum->seo_name.'/galeri') }}">Galeri Foto</a></span>
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

@push('jscode')
  <script type="text/javascript">
    function filterKategori (filterForm) {
      var filterVal   = filterForm.value;
      // $('#filterForm').val(filterVal);
      if(filterVal != '') {
        // alert(filterVal);
        document.location = '{{ url("aum/".$aum->seo_name."/artikelkategori") }}' + '/' + filterVal;
      }
    }
  </script>
@endpush
@endsection

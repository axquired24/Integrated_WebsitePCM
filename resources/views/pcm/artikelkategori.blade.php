@extends('layouts.pcm_home')
@section('title', 'Kategori Artikel')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-5 col-xs-10">
            <h2><span class="fa fa-newspaper-o"></span>&nbsp; {{ $kategori->name }}</h2>
        </div>
        <div class="col-md-7 col-xs-2">
            <form class="form-inline pull-right">
              <div class="form-group hidden-sm-down">
                <label for="filterKabar">Filter</label>
                <select class="custom-select" onchange="filterKategori(this)" id="filterForm">
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
        @if(count($beritas) < 1)
          <div class="col-xs-12">
            <div class="card">
              <div class="card-block">
                <h4 class="card-title">Tidak Ditemukan</h4>
                <small class="card-subtitle text-muted">Pencarian Tidak ditemukan</small>
                <br><br>
                <a href="{{ url('/') }}" class="card-link btn btn-outline-primary">Kembali ke Home</a>
              </div>
            </div>
          </div>
        @else

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
        @endif
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
    $('#filterForm').val('{{ $kategori->id }}');
  });

    function filterKategori (filterForm) {
      var filterVal   = filterForm.value;
      if(filterVal != '') {
        // alert(filterVal);
        document.location = '{{ url("artikelkategori") }}' + '/' + filterVal;
      }
    }
  </script>
@endpush
@endsection

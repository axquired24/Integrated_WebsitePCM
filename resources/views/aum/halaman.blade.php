@extends('layouts.aum_home')
@section('title', $halaman->title)
@section('content')
@push('csscode')
	<style>
    body {
      padding-top: 80px;
    }
		.artikelteks {
			line-height: 2.1rem;
		}

    #gmaps-canvas {
      min-height: 300px;
      width: 100%;
    }

    .navbar-transparent {
      -webkit-transition: all 0.25s ease-out;
      transition: all 0.25s ease-out;
      background-color: rgba(254,0,0,1);
    }
	</style>
@endpush

<div class="container">
	<div class="row">
		<div class="col-md-7 col-lg-8">
			<div class="card">
				<div class="card-block">
					<h4 class="card-title"> {{ $halaman->title }} </h4>
					<br>
					<h6 class="card-subtitle text-muted">
						<span class="float-xs-right">
							<span class="fa fa-calendar-o"></span>&nbsp; {{ date_format($halaman->updated_at, 'd F Y') }}
						</span>
					</h6>
				</div>
				<img class="img-fluid" src="{{ URL::asset('files/halaman/'.$aum->id.'/'.$halaman->image_path) }}" alt="Gambar : {{ $halaman->title }}">
				<div class="card-block">
					<div class="card-text text-justify mx-2 artikelteks">
						{!! $halaman->content !!}
						<p class="text-xs-center">
						<a class="btn btn-primary" href="#shareArtikel"><span class="fa fa-share-alt"></span> Bagikan Informasi ini</a>
						</p>
					</div>
				</div>
			</div>
		</div> {{-- col-md-7 --}}

		<div class="col-md-5 col-lg-4">
            @if($halaman->title == 'Profil')
            {{-- Sidebar Menu --}}
            <div class="card">
              <div class="card-header text-white bg-sekolah font-weight-bold">
                Lokasi
              </div>
              <div class="card-block">
                <div class="row">
                  <div class="col-xs-12">
                    <div id="gmaps-canvas"></div>
                  </div>
                </div>
              </div>
            </div>
            {{-- END Sidebar Menu --}}
            @endif

            {{-- Sidebar Menu --}}
            <a name="shareArtikel"></a>
            <div class="card">
              <div class="card-header text-white bg-sekolah font-weight-bold">
                Bagikan Lewat
              </div>
              <div class="card-block">
                <ul class="media-list">
                  @foreach($shares as $share)
                  <li class="media">
                    <a class="media-left bg-sekolah" href="{{ $share['link'] }}" style="padding:0.7rem">
                      <h5 class="text-white text-xs-center">
                        <span class="fa {{ $share['fa'] }}"></span>
                      </h5>
                    </a>
                    <div class="media-body">
                      <h6 class="media-heading mx-1"><a class="noUnderline text-sekolah" href="{{ $share['link'] }}">{{ $share['name'] }}</a></h6>
                      <small class="card-subtitle mx-1">
                          <span class="text-muted">{{ $share['ot'] }}</span> <br>
                      </small>
                    </div>
                  </li> {{-- media --}}
                  <hr>
                  @endforeach
                </ul> {{-- media-list --}}
              </div>
            </div>
            {{-- END Sidebar Menu --}}
		</div> {{-- col-md-5 --}}
	</div> {{-- row --}}
	<br><br>

	<div class="row">
        <div class="col-md-6">
            <div class="hidden-sm-up">
                <hr>
            </div>
            <h2>Kabar Terbaru <span class="fa fa-newspaper-o pull-right hidden-sm-down"></span></h2>
            <hr>
            <ul class="media-list">
                @if(count($beritas) > 0)
                @foreach($beritas as $berita)
                <li class="media">
                  <a class="media-left" href="{{ url('aum/'.$aum->seo_name.'/artikel/'.$berita->id) }}">
                    <img class="media-object" src="{{ URL::asset('files/artikel/'.$aum->id.'/'.$berita->image_path) }}" width="50px" height="48px" alt="Gambar : {{ $berita->title }}">
                  </a>
                  <div class="media-body">
                    <h6 class="media-heading"><a class="noUnderline" href="{{ url('aum/'.$aum->seo_name.'/artikel/'.$berita->id) }}">{{ str_limit($berita->title, 40) }}</a></h6>
                    {!! str_limit(strip_tags($berita->content), 130) !!}<br>
                    <span class="tag tag-pill tag-success">Berita</span> &nbsp; <small class="text-muted">{{ date_format($berita->updated_at, 'd F Y') }}</small>
                  </div>
                  <br>
                </li> {{-- media --}}
                @endforeach

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
        {{-- col-md-left --}}

        <div class="col-md-6">
            <div class="hidden-sm-up">
                <hr>
            </div>
            <h2>Informasi & Pengumuman <span class="fa fa-bar-chart pull-right hidden-sm-down"></span></h2>
            <hr>
            <ul class="media-list">
                @if(count($pengumumans) > 0)
                @foreach($pengumumans as $pengumuman)
                <li class="media">
                  <a class="media-left" href="{{ url('aum/'.$aum->seo_name.'/artikel/'.$pengumuman->id) }}">
                    <img class="media-object" src="{{ URL::asset('files/artikel/'.$aum->id.'/'.$pengumuman->image_path) }}" width="50px" height="48px" alt="Gambar : {{ $pengumuman->title }}">
                  </a>
                  <div class="media-body">
                    <h6 class="media-heading"><a class="noUnderline" href="{{ url('aum/'.$aum->seo_name.'/artikel/'.$pengumuman->id) }}">{{ str_limit($pengumuman->title, 40) }}</a></h6>
                    {!! str_limit(strip_tags($pengumuman->content), 130) !!}<br>
                    <span class="tag tag-pill tag-danger">Pengumuman</span> &nbsp; <small class="text-muted">{{ date_format($pengumuman->updated_at, 'd F Y') }}</small>
                  </div>
                  <br>
                </li> {{-- media --}}
                @endforeach

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
	</div>
</div>

@push('jscode')
    <script src="http://maps.google.com/maps/api/js?key={{ env('GOOGLE_APIKEY') }}&language=id&region=ID"></script>
    <script src="{{ URL::asset('assets/gmap/gmaps.min.js') }}"></script>
    <script type="text/javascript">
        // Set to Indonesia Lat, Lng
        var map = new GMaps({
          div: '#gmaps-canvas',
          lat: {{ $aum->gmap_lat }},
          lng: {{ $aum->gmap_lng }},
          zoom: 15
        }); // var GMaps

        map.addMarker({
          lat: {{ $aum->gmap_lat }},
          lng: {{ $aum->gmap_lng }},
          title: '{{ $aum->name }}',
          infoWindow: {
            content: '<b>{{ $aum->name }}</b>'
          }
          // ,click: function(e) {
          //   alert('You clicked in this marker');
          // }
        }); // map.addMarker
    </script>
@endpush

@endsection
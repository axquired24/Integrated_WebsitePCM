@extends('layouts.pcm_home')
@section('title', $artikel->title)
@section('content')
@push('csscode')
	<style>
		.artikelteks {
			line-height: 2.1rem;
		}
	</style>
@endpush

<div class="container">
	<div class="row">
		<div class="col-md-7 col-lg-8">
			<div class="card">
				<div class="card-block">
					<h4 class="card-title"> {{ $artikel->title }} </h4>
					<br>
					<h6 class="card-subtitle text-muted">
						<span class="fa fa-user"></span>&nbsp; {{ $artikel->user->name }} &nbsp;
						<a class="card-link" href="{{ url('artikelkategori/'.$artikel->articleCategory->id) }}"><span class="fa fa-tag"></span>&nbsp; {{ $artikel->articleCategory->name }}</a> &nbsp;
						<br class="hidden-sm-up">
						<br class="hidden-sm-up">
						<span class="float-xs-right">
							<span class="fa fa-calendar-o"></span>&nbsp; {{ date_format($artikel->updated_at, 'd F Y') }}
						</span>
					</h6>
				</div>
				<img class="img-fluid" src="{{ URL::asset('files/artikel/'.$aum->id.'/'.$artikel->image_path) }}" alt="Gambar : {{ $artikel->title }}">
				<div class="card-block">
					<div class="card-text text-justify mx-2 artikelteks">
						{!! $artikel->content !!}
						<p class="text-xs-center">
						<a class="btn btn-primary" href="#shareArtikel"><span class="fa fa-share-alt"></span> Bagikan Artikel Ini</a>
						</p>
					</div>
				</div>
			</div>
		</div> {{-- col-md-7 --}}

		<a name="shareArtikel"></a>
		<div class="col-md-5 col-lg-4">
            
            {{-- Sidebar Menu --}}
            <div class="card">
              <div class="card-header text-white bg-pcm font-weight-bold">
                Bagikan Lewat
              </div>
              <div class="card-block">
                <ul class="media-list">
                  @foreach($shares as $share)
                  <li class="media">
                    <a class="media-left bg-pcm" href="{{ $share['link'] }}" style="padding:0.7rem">
                      <h5 class="text-white text-xs-center">
                        <span class="fa {{ $share['fa'] }}"></span>
                      </h5>
                    </a>
                    <div class="media-body">
                      <h6 class="media-heading mx-1"><a class="noUnderline text-pcm" href="{{ $share['link'] }}">{{ $share['name'] }}</a></h6>
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

            <div class="card">
				<div class="card-header text-white bg-pcm font-weight-bold">
					Tentang Penulis
				</div>            	
            	<div class="card-block">
            		<h6 class="card-title">Nama :</h6> {{ $artikel->user->name }} <br><br>
            		@if($artikel->user->nbm != '')
            		<h6 class="card-title">NBM :</h6> {{ $artikel->user->nbm }} <br><br>
            		@endif
            		@if($artikel->user->alamat != '')
            		<h6 class="card-title">Alamat :</h6> {{ $artikel->user->alamat }} <br><br>
            		@endif
            		<h6 class="card-title">Email :</h6> <a class="card-link" href="mailto:{{ $artikel->user->email }}">{{ $artikel->user->email }}</a> <br><br>
            	</div>
            </div>

		</div> {{-- col-md-5 --}}
	</div> {{-- row --}}
	<br><br>

	<div class="row">
        <div class="col-md-6">
            <div class="hidden-sm-up">
                <hr>
            </div>
            <h2>Berita Terkait <span class="fa fa-newspaper-o pull-right hidden-sm-down"></span></h2>
            <hr>
            <ul class="media-list">
                @if(count($pengumumans) > 0)
                @foreach($pengumumans as $pengumuman)
                <li class="media">
                  <a class="media-left" href="#">
                    <img class="media-object" src="{{ URL::asset('files/artikel/'.$aum->id.'/'.$pengumuman->image_path) }}" width="50px" height="48px" alt="Gambar : {{ $pengumuman->title }}">
                  </a>
                  <div class="media-body">
                    <h6 class="media-heading"><a class="noUnderline" href="#">{{ str_limit($pengumuman->title, 40) }}</a></h6>
                    {!! str_limit(strip_tags($pengumuman->content), 130) !!}<br>
                    <span class="tag tag-pill tag-success">Berita</span> &nbsp; <small class="text-muted">{{ date_format($pengumuman->updated_at, 'd F Y') }}</small>
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
                  <a class="media-left" href="{{ url('artikel/'.$pengumuman->id) }}">
                    <img class="media-object" src="{{ URL::asset('files/artikel/'.$aum->id.'/'.$pengumuman->image_path) }}" width="50px" height="48px" alt="Gambar : {{ $pengumuman->title }}">
                  </a>
                  <div class="media-body">
                    <h6 class="media-heading"><a class="noUnderline" href="{{ url('artikel/'.$pengumuman->id) }}">{{ str_limit($pengumuman->title, 40) }}</a></h6>
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

@endsection
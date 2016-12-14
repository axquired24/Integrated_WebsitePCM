@extends('layouts.aum_home')
@section('title', 'Galeri '.$aum->name)
@section('content')

@push('csscode')
	<style>
		body {
		  padding-top: 80px;
		}

		.navbar-transparent {
		  -webkit-transition: all 0.25s ease-out;
		  transition: all 0.25s ease-out;
		  background-color: rgba(254,0,0,1);
		} 
		.galeri {
			height: 300px;
		}
	</style>
@endpush

{{-- .container>.row>(.col-md-4.col-xs-12>.card>img.img-top.img-fluid+.card-header+.card-block)*3 --}}
<div class="container">
	<div class="row">
		<div class="col-xs-12">
			<h2>Galeri {{ $aum->name }} <span class="fa fa-image pull-right hidden-sm-down"></span></h2>
			<hr>
		</div>
	</div>
	<div class="row">	
	@foreach($galerikategoris as $galeri)
		<?php 
			$img 		= App\Models\Gallery::where('gallery_category_id', $galeri->id)->inRandomOrder()->first();
			$galeri_c 	= App\Models\Gallery::where('gallery_category_id', $galeri->id)->count();
			if($galeri_c < 1)
			{
				$galeri_c 	= 'Belum Ada';
			}
		?>
		<div class="col-md-4 col-xs-12">
			<div class="card">
				<a href="{{ url('aum/'.$aum->seo_name.'/galerikategori/'.$galeri->id) }}"><img src="{{ URL::asset('files/galeri/'.$aum->id.'/'.$img['filename']) }}" alt="Thumbnail Galeri {{ $galeri->name }}" class="img-top img-fluid w-100 galeri"></a>
				<div class="card-block">
					<h5 class="card-title">{{ $galeri->name }} <small class="text-muted">{{ $galeri_c }} Gambar</small></h5>
					<a href="{{ url('aum/'.$aum->seo_name.'/galerikategori/'.$galeri->id) }}" class="btn btn-sm btn-primary">Lihat Galeri Ini</a>
				</div>
			</div>
		</div>
	@endforeach
	</div>
</div>
@endsection
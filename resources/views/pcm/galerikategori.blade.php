@extends('layouts.pcm_home')
@section('title', 'Galeri : '.$galerikategori->name)
@section('content')

@push('csscode')
	<style>
		.galeri {
			height: 300px;
		}
	</style>
@endpush

{{-- .container>.row>(.col-md-4.col-xs-12>.card>img.img-top.img-fluid+.card-header+.card-block)*3 --}}
<div class="container">
	<div class="row">
		<div class="col-xs-12">
			<h2><a href="{{ url('galeri') }}" class="card-link"><span class="fa fa-chevron-left"></span></a>&nbsp;
			{{ $galerikategori->name }} <small class="text-muted">({{ $aum->name }})</small><span class="fa fa-image pull-right hidden-sm-down"></span></h2>
			<hr>
		</div>
	</div>
	<div class="row">	
	@foreach($galeris as $galeri)
		<div class="col-md-4 col-xs-12">
			<div class="card">
				<a href="{{ url('files/galeri/'.$aum->id.'/'.$galeri->filename) }}"><img src="{{ URL::asset('files/galeri/'.$aum->id.'/'.$galeri->filename) }}" alt="{{ $galeri->filename }}" class="img-top img-fluid w-100 galeri"></a>
				<div class="card-block">
					<h5 class="card-title">#{{ $galeri->id }} <small class="text-muted">{{ $galeri->filename }}</small></h5>
				</div>
			</div>
		</div>
	@endforeach
	</div>


	<div align="center" class="row"> {{-- Pagination --}}
        <nav aria-label="Page navigation">
          @include('layouts.pagination', ['paginator' => $galeris])
        </nav>
    </div> {{-- row --}}
</div> {{-- container --}}
@endsection
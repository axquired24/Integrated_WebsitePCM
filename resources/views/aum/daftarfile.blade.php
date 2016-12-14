@extends('layouts.aum_home')
@section('title', 'Daftar File Download '.$aum->name)
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
	</style>
@endpush

<div class="container">
	<div class="row">
		<div class="col-xs-12">
			<h2>Download File <span class="fa fa-download pull-right hidden-sm-down"></span></h2>
			<hr>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
		@foreach($listfiles as $dfile)
			<div class="card">
				<div class="card-block">
					<a href="{{ url('aum/'.$aum->seo_name.'/file/download/'.$dfile->id) }}" class="btn btn-success pull-right"><span class="fa fa-download"></span></a>
					<b>#{{ $dfile->id }}</b> <a href="{{ url('aum/'.$aum->seo_name.'/file/download/'.$dfile->id) }}" class="card-link">{{ $dfile->title }}</a> <br>
					<small class="text-muted">{{ $dfile->filename }} // {{ date_format($dfile->updated_at, 'd F Y') }}</small>					
				</div>
			</div>
		@endforeach
		</div>
	</div>

	<div align="center" class="row"> {{-- Pagination --}}
        <nav aria-label="Page navigation">
          @include('layouts.pagination', ['paginator' => $listfiles])
        </nav>
    </div> {{-- row --}}
</div>
@endsection
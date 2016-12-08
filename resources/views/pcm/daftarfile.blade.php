@extends('layouts.pcm_home')
@section('title', 'Daftar File Download '.$aum->name)
@section('content')

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
					<a href="{{ url('file/download/'.$dfile->id) }}" class="btn btn-success pull-right"><span class="fa fa-download"></span></a>
					<b>#{{ $dfile->id }}</b> <a href="{{ url('file/download/'.$dfile->id) }}" class="card-link">{{ $dfile->title }}</a> <br>
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
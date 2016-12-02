@extends('layouts.admin')
@section('title', 'Tambah Menu ')
@section('content')
@push('csscode')
    {{-- <link rel="stylesheet" href="{{ url('assets/ckeditor_basic/samples/css/samples.css') }}"> --}}
    <style>
        .form-group .label {
            cursor: pointer;
        }
    </style>
@endpush 

  {{-- Jumbotron --}}
  <div class="jumbotron py-1">
    <h2>Tambah Menu <span class="fa fa-columns float-xs-right"></span></h2>
  </div>
  {{-- EOF Jumbotron --}}

  @if (count($errors) > 0)
    <div class="alert alert-danger py-1">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
  @endif

  <form action="{{ url('admin/menu/add') }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="form-group row">
      <label for="textInput" class="col-xs-2 col-form-label">Nama Menu</label>
      <div class="col-xs-10">
        <input name="name" class="form-control" type="text" value="{{ old('name') }}" id="textInput" required>
      </div>
    </div>

    <div class="form-group row">
      <label for="textInput" class="col-xs-2 col-form-label">Link</label>
      <div class="col-xs-10">
        <input name="link" class="form-control" type="text" value="{{ old('link') }}" id="textInput" required>
      </div>
    </div>  

    <div align="center">      
      <button type="submit" class="btn btn-lg btn-primary">Simpan</button>
    </div>
  </form>

  @push('jscode')
    <script>
        $("#menu-artikel").addClass("active");
    </script>
  @endpush

@endsection
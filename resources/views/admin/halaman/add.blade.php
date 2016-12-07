@extends('layouts.admin')
@section('title', 'Tambah Halaman ')
@section('content')
@push('csscode')
    {{-- <link rel="stylesheet" href="{{ url('assets/ckeditor_basic/samples/css/samples.css') }}"> --}}
    <link rel="stylesheet" href="{{ url('assets/ckeditor_basic/samples/toolbarconfigurator/lib/codemirror/neo.css') }}">
    <style>
        .form-group .label {
            cursor: pointer;
        }
    </style>
@endpush 

  {{-- Jumbotron --}}
  <div class="jumbotron py-1">
    <h2>Tambah Halaman <span class="fa fa-file-text float-xs-right"></span></h2>
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

  <form action="{{ url('admin/halaman/add') }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="form-group row">
      <label for="textInput" class="col-xs-2 col-form-label">Judul</label>
      <div class="col-xs-10">
        <input name="title" class="form-control" type="text" value="{{ old('title') }}" id="textInput" required>
      </div>
    </div>

    <div class="form-group row">
      <label for="textInput" class="col-xs-2 col-form-label">Konten Halaman <small>(hanya teks)</small></label>
      <div class="col-xs-10">
        <textarea id="editor" name="content" rows="5" class="form-control" type="text" required>{{ old('content') }}</textarea>
      </div>
    </div>

    <div class="form-group row">
      <label for="textInput" class="col-xs-2 col-form-label">Gambar</label>
      <div class="col-xs-10">
        <input id="image_file" name="file" class="form-control" type="file" required>
      </div>
    </div>    

    <div align="center">
      <button type="submit" class="btn btn-lg btn-primary">Publikasikan</button>
    </div>
  </form>

  @push('jscode')
    <script src="{{ url('assets/ckeditor_basic/ckeditor.js') }}"></script>
    <script src="{{ url('assets/ckeditor_basic/config.js') }}"></script>
    <script src="{{ url('assets/ckeditor_basic/samples/js/sample.js') }}"></script>
    <script>
        initSample();
        $("#image_file").attr({'accept' : '.jpg, .png, .jpeg'})
        $("#menu-artikel").addClass("active");
    </script>
  @endpush

@endsection
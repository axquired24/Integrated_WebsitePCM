@extends('layouts.admin')
@section('title', 'Edit Halaman ')
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
    <h2>Edit Halaman <span class="fa fa-file-text float-xs-right"></span></h2>
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

  <form action="{{ url('admin/halaman/edit') }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <input type="hidden" name="id" value="{{ $page->id }}">
    <div class="form-group row">
      <label for="textInput" class="col-xs-2 col-form-label">Judul</label>
      <div class="col-xs-10">
        <input name="title" class="form-control" type="text" value="{{ $page->title }}" id="textInput" required>
      </div>
    </div>

    <div class="form-group row">
      <label for="textInput" class="col-xs-2 col-form-label">Konten Halaman <small>(hanya teks)</small></label>
      <div class="col-xs-10">
        <textarea id="editor" name="content" rows="5" class="form-control" type="text" required>{!! $page->content !!}</textarea>
      </div>
    </div>

    <div class="form-group row">
      <label for="textInput" class="col-xs-2 col-form-label">Gambar</label>
      <div class="col-xs-10" id="image-viewer">
        <img class="img-fluid" src="{{ URL::asset('files/halaman/'.Auth::user()->aum_list_id.'/thumb-'.$page->image_path) }}" alt="Gambar - {{ $page->title }}"> <br><a href="javascript:void" id="showField">Ganti gambar</a>
      </div>
      <div class="col-xs-10" id="image-browser">
        <input id="image_file" name="file" class="form-control" type="file">
        <div class="form-text"><a href="javascript:void" id="hideField">Tetap gambar lama</a></div>
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

        // Toggle Hide/show image-browser
        $("#image-browser").hide();
        $("#image-viewer").show();

        $("#showField").click( function(){
          $("#image-viewer").toggle();
          $("#image-browser").toggle();
          $("#image_file").attr({'required':''})
        });
        $("#hideField").click( function(){
          $("#image-viewer").toggle();
          $("#image-browser").toggle();
          $("#image_file").val('')
          $("#image_file").removeAttr('required')
        });
    </script>
  @endpush

@endsection
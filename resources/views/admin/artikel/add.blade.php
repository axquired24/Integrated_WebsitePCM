@extends('layouts.admin')
@section('title', 'Tambah Artikel ')
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

  {{-- {{ dd($pengumuman) }} --}}
  
  @if($catCount == 0)
    {{-- Jumbotron --}}
  <div class="jumbotron py-1">
    <h2>Tambah 
      @if($pengumuman == '')
      Artikel <span class="fa fa-newspaper-o float-xs-right"></span>
      @else
      Pengumuman <span class="fa fa-warning float-xs-right"></span>
      @endif
    </h2>
    <p>Sebelum menambah artikel, <b>tambahkan minimal 1 kategori</b> untuk artikel. <br><br>
    <a href="{{ url('admin/artikel/kategori/add') }}" class="btn btn-danger"><span class="fa fa-plus-circle hidden-xs-down"></span> Tambah Kategori</a>
    <a href="#" class="btn btn-outline-primary hidden-sm-up" data-toggle="offcanvas"><span class="fa fa-navicon"></span> Buka Menu</a>
    </p>
  </div>
  {{-- EOF Jumbotron --}}
  @else  

  {{-- Jumbotron --}}
  <div class="jumbotron py-1">
    <h2>Tambah 
      @if($pengumuman == '')
      Artikel <span class="fa fa-newspaper-o float-xs-right"></span>
      @else
      Pengumuman <span class="fa fa-warning float-xs-right"></span>
      @endif
    </h2>
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

  <form action="{{ url('admin/kelola/artikel/add') }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    @if($pengumuman != '')
      <input type="hidden" name="pengumuman" value="{{ $pengumuman->id }}">
    @endif
    <div class="form-group row">
      <label for="textInput" class="col-xs-2 col-form-label">Judul</label>
      <div class="col-xs-10">
        <input name="title" class="form-control" type="text" value="{{ old('title') }}" id="textInput" required>
      </div>
    </div>

    <div class="form-group row">
      <label for="textInput" class="col-xs-2 col-form-label">Kategori</label>
      <div class="col-xs-10">
        <select name="article_category_id" class="form-control" required>
          @if($pengumuman == '')
            @foreach($arCategory as $kategori)
            <option value="{{ $kategori->id }}">{{ $kategori->name }}</option>
            @endforeach
          @else
            <option value="{{ $pengumuman->id }}">{{ $pengumuman->name }}</option>
          @endif
        </select>
      </div>
    </div>

    <div class="form-group row">
      <label for="textInput" class="col-xs-2 col-form-label">Konten</label>
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

  {{-- EOF if(catCount) --}}
  @endif 

@endsection
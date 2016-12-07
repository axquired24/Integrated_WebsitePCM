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
    <h2>Edit Menu <span class="fa fa-columns float-xs-right"></span></h2>
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

  <form action="{{ url('admin/menu/edit') }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <input type="hidden" name="id" value="{{ $menu->id }}">
    <div class="form-group row">
      <label for="textInput" class="col-xs-2 col-form-label">Nama Menu</label>
      <div class="col-xs-10">
        <input name="name" class="form-control" type="text" value="{{ $menu->name }}" id="textInput" placeholder="Judul Menu" required>
      </div>
    </div>

    <div class="form-group row">
      <label for="textInput" class="col-xs-2 col-form-label">Link</label>
      <div class="col-xs-10">
        <input name="link" class="form-control" type="text" value="{{ $menu->link }}" id="textInput" placeholder="http://contohlink.co.id/sub/id/1" required>
      </div>
    </div>  

    <div align="center">      
      <button type="submit" class="btn btn-lg btn-primary">Simpan</button>
    </div>
  </form>

  <br><br>
  <div class="alert alert-info">
    <span class="fa fa-info-circle"></span>&nbsp; <b>Informasi</b> <br> Untuk mengarahkan menu ke kustom halaman. Buka <a href="{{ url('admin/halaman') }}" target="_blank">daftar halaman</a>, kemudian klik kanan pada tombol <span class="fa fa-file-text-o"></span> (pada kustom halaman yang dipilih) > salin tautan(copy link) dan <em>paste</em> pada kotak <b>Link</b> diatas.
  </div>

  @push('jscode')
    <script>
        $("#menu-artikel").addClass("active");
    </script>
  @endpush

@endsection
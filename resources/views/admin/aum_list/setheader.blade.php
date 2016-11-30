@extends('layouts.admin')
@section('title', 'Ubah Header Halaman')
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

  @if(! isset($aum->id))
    <?php
      $aum = Session::get('aum');
    ?>
  @endif

  {{-- Jumbotron --}}
  <div class="jumbotron py-1">
    <h2>Header <small>Situs {{ $aum->name }}</small><span class="fa fa-desktop float-xs-right"></span></h2>
    <p>Untuk resolusi terbaik, upload header dengan lebar minimal 1024px</p>
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

  <form action="{{ url('admin/kelola/aum/setheader') }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <input type="hidden" name="id" value="{{ $aum->id }}">

    @if($aum->header_path != '')
    <div class="form-group row">
      <label for="textInput" class="col-xs-2 col-form-label">Header Lama</label>
      <div class="col-xs-10" id="image-viewer">
        <img class="img-fluid" src="{{ URL::asset('files/header/'.$aum->id.'/thumb-'.$aum->header_path) }}" alt="Header - {{ $aum->name }}">
      </div>
    </div>
    @endif

    <div class="form-group row">
      <label for="textInput" class="col-xs-2 col-form-label">Header Baru</label>
      <div class="col-xs-10" id="image-browser">
        <input id="image_file" name="file" class="form-control" type="file">
      </div>
    </div>

    <div align="center">
      <button type="submit" class="btn btn-lg btn-primary">Terapkan</button>
    </div>
  </form>

  @push('jscode')
    <script>
        $(document).ready(function(){                
          $("#image_file").attr({'accept' : '.jpg, .png, .jpeg'});
          $("#image_file").attr({'required':'required'});
        });
    </script>
  @endpush

@endsection
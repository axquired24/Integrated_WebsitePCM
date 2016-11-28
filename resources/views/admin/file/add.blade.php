@extends('layouts.admin')
@section('title', 'Tambah File ')
@section('content')
@push('csscode')
    <style>
        .form-group .label {
            cursor: pointer;
        }
    </style>
@endpush

  {{-- Jumbotron --}}
  <div class="jumbotron py-1">
    <h2>Tambah File <span class="fa fa-upload float-xs-right"></span></h2>
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

  <form action="{{ url('admin/file/add') }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="form-group row">
      <label for="textInput" class="col-xs-2 col-form-label">Judul File</label>
      <div class="col-xs-10">
        <input name="title" class="form-control" type="text" value="{{ old('title') }}" id="textInput" required>
      </div>
    </div>

    <div class="form-group row">
      <label for="textInput" class="col-xs-2 col-form-label">Pilih File</label>
      <div class="col-xs-10">
        <input name="file" class="form-control" type="file" required>
      </div>
    </div>    

    <div align="center">
      <button type="submit" class="btn btn-lg btn-primary">Upload</button>
    </div>
  </form>

@endsection
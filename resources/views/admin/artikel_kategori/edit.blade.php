@extends('layouts.admin')
@section('title', 'Tambah Kategori Artikel ')
@section('content')
  {{-- Jumbotron --}}
  <div class="jumbotron py-1">
    <h2>Ubah Kategori Artikel <span class="fa fa-newspaper-o float-xs-right"></span></h2>
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

  <form action="{{ url('admin/artikel/kategori/edit') }}" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="id" value="{{ $arCategory->id }}">
    <div class="form-group row">
      <label for="textInput" class="col-xs-2 col-form-label">Kategori</label>
      <div class="col-xs-10">
        <input name="name" class="form-control" type="text" value="{{ $arCategory->name }}" id="textInput" required>
      </div>
    </div>

    <div align="center">
      <button type="submit" class="btn btn-lg btn-primary">Simpan Perubahan</button>
    </div>
  </form>

@endsection
@extends('layouts.admin')
@section('title', 'Tambah Pengguna ')
@section('content')
  {{-- Jumbotron --}}
  <div class="jumbotron py-1">
    <h2>Tambah Pengguna <span class="fa fa-users float-xs-right"></span></h2>
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

  <form action="{{ url('admin/kelola/pengguna/add') }}" method="post">
    {{ csrf_field() }}
    <div class="form-group row">
      <label for="textInput" class="col-xs-2 col-form-label">Nama *</label>
      <div class="col-xs-10">
        <input name="name" class="form-control" type="text" value="{{ old('name') }}" id="textInput" required>
      </div>
    </div>

    <div class="form-group row">
      <label for="textInput" class="col-xs-2 col-form-label">NBM</label>
      <div class="col-xs-10">
        <input name="nbm" class="form-control" type="text" value="{{ old('nbm') }}" id="textInput">
      </div>
    </div>

    <div class="form-group row">
      <label for="textInput" class="col-xs-2 col-form-label">Alamat</label>
      <div class="col-xs-10">
        <input name="alamat" class="form-control" type="text" value="{{ old('alamat') }}" id="textInput">
      </div>
    </div>

    <div class="form-group row">
      <label for="textInput" class="col-xs-2 col-form-label">Telepon</label>
      <div class="col-xs-10">
        <input name="phone" class="form-control" type="text" value="{{ old('phone') }}" id="textInput">
      </div>
    </div>

    <div class="form-group row">
      <label for="textInput" class="col-xs-2 col-form-label">Instansi *</label>
      <div class="col-xs-10">
        <select name="aum_list_id" class="form-control" required>
          @foreach($aums as $aum)
          <option value="{{ $aum->id }}">{{ $aum->name }}</option>
          @endforeach
        </select>
        <small class="form-text text-muted">Instansi Baru? Tambahkan <a href="{{ url('admin/kelola/aum/add') }}">disini</a></small>
      </div>
    </div>

    <br>
    <div class="alert alert-info">
      <h6>Informasi Login</h6>
    </div>

    <div class="form-group row">
      <label for="textInput" class="col-xs-2 col-form-label">Email *</label>
      <div class="col-xs-10">
        <input name="email" class="form-control" type="email" value="{{ old('email') }}" id="textInput" required>
      </div>
    </div>

    <div class="form-group row">
      <label for="textInput" class="col-xs-2 col-form-label">Password *</label>
      <div class="col-xs-10">
        <input name="password" class="form-control" type="password" value="{{ old('password') }}" id="textInput" required>
      </div>
    </div>

    <div class="form-group row">
      <label for="textInput" class="col-xs-2 col-form-label">Level *</label>
      <div class="col-xs-10">
        <select name="level" class="form-control" required>
          <option value="staff">staff</option>
          <option value="admin">admin</option>
          <option value="kontributor">kontributor</option>
        </select>
      </div>
    </div>

    <div class="form-group row">
      <label for="textInput" class="col-xs-2 col-form-label">Status *</label>
      <div class="col-xs-10">
        <select name="status" class="form-control" required>
          <option value="1">aktif</option>
          <option value="0">non-aktif</option>
        </select>
      </div>
    </div>

    <div align="center">
      <button type="submit" class="btn btn-lg btn-primary">Tambah</button>
    </div>
  </form>

@endsection
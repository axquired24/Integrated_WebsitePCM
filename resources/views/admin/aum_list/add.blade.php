@extends('layouts.admin')
@section('title', 'Kelola Sub Situs ')
@section('content')
  {{-- Jumbotron --}}
  <div class="jumbotron py-1">
    <h2>Tambah Sub Situs <span class="fa fa-sitemap float-xs-right"></span></h2>
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


  <form action="{{ url('admin/kelola/aum/add') }}" method="post">
    {{ csrf_field() }}
    <div class="form-group row">
      <label for="textInput" class="col-xs-2 col-form-label">Nama *</label>
      <div class="col-xs-10">
        <input name="name" class="form-control" type="text" value="{{ old('name') }}" id="textInput" placeholder="Nama Amal Usaha" required>
      </div>
    </div>

    <div class="form-group row">
      <label for="textInput" class="col-xs-2 col-form-label">Alamat * <small><br>(dan Koordinat Google Map)</small></label>
      <div class="col-xs-10">
        <textarea name="address" rows="3" class="form-control" id="textInput" required>{{ old('address') }}</textarea>
        <br>
        <input name="gmap_lat" class="form-control" type="text" value="{{ old('gmap_lat') }}" id="textInput" placeholder="Latitude GMAPS" required>
        <br>
        <input name="gmap_lng" class="form-control" type="text" value="{{ old('gmap_lng') }}" id="textInput" placeholder="Longtitude GMAPS" required>
      </div>
    </div>

    <div class="form-group row">
      <label for="textInput" class="col-xs-2 col-form-label">Kontak *</label>
      <div class="col-xs-10">
        <input name="contact" class="form-control" type="text" value="{{ old('contact') }}" id="textInput" placeholder="Nomor Kantor/ HP" required>
      </div>
    </div>

    <div align="center">
      <button type="submit" class="btn btn-lg btn-primary">Tambah</button>
    </div>
  </form>

@endsection
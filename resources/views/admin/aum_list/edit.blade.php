@extends('layouts.admin')
@section('title', 'Kelola Sub Situs ')
@section('content')
  {{-- Jumbotron --}}
  <div class="jumbotron py-1">
    <h2>Perbarui Sub Situs <span class="fa fa-sitemap float-xs-right"></span></h2>
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


  <form action="{{ url('admin/kelola/aum/edit') }}" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="id" value="{{ $aum->id }}">
    <div class="form-group row">
      <label for="textInput" class="col-xs-2 col-form-label">Nama *</label>
      <div class="col-xs-10">
        <input name="name" class="form-control" type="text" value="{{ $aum->name }}" id="textInput" placeholder="Nama Amal Usaha" required>
      </div>
    </div>

    <div class="form-group row">
      <label for="textInput" class="col-xs-2 col-form-label">Alamat * <small><br>(dan Koordinat Google Map)</small></label>
      <div class="col-xs-10">
        <textarea name="address" rows="3" class="form-control" id="textInput" required>{{ $aum->address }}</textarea>
        <small class="form-text"><span class="fa fa-external-link-square"></span>&nbsp; Cara Mendapatkan <a target="_blank" class="card-link" href="https://support.google.com/maps/answer/18539?co=GENIE.Platform%3DDesktop&hl=id">Koordinat</a> (<a target="_blank" href="https://support.google.com/maps/answer/18539?co=GENIE.Platform%3DDesktop&hl=id">English Version</a>)</small>
        <br>
        <input name="gmap_lat" class="form-control" type="text" value="{{ $aum->gmap_lat }}" id="textInput" placeholder="Latitude GMAPS (Garis Lintang)" required>
        <br>
        <input name="gmap_lng" class="form-control" type="text" value="{{ $aum->gmap_lng }}" id="textInput" placeholder="Longtitude GMAPS (Garis Bujur)" required>
      </div>
    </div>

    <div class="form-group row">
      <label for="textInput" class="col-xs-2 col-form-label">Kontak *</label>
      <div class="col-xs-10">
        <input name="contact" class="form-control" type="text" value="{{ $aum->contact }}" id="textInput" placeholder="Nomor Kantor/ HP" required>
      </div>
    </div>

    <div align="center">
      <button type="submit" class="btn btn-lg btn-primary">Simpan Perubahan</button>
    </div>
  </form>

@endsection
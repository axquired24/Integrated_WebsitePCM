@extends('layouts.admin')
@section('title', 'Ubah Data Pengguna ')
@section('content')
  {{-- Jumbotron --}}
  <div class="jumbotron py-1">
    <h2>Ubah Data Pengguna <span class="fa fa-users float-xs-right"></span></h2>
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

  <form action="{{ url('admin/kelola/pengguna/edit') }}" method="post">
    {{ csrf_field() }}
    <input type="hidden" value="{{ $user->id }}" name="id">
    <div class="form-group row">
      <label for="textInput" class="col-xs-2 col-form-label">Nama *</label>
      <div class="col-xs-10">
        <input name="name" class="form-control" type="text" value="{{ $user->name }}" id="textInput" required>
      </div>
    </div>

    <div class="form-group row">
      <label for="textInput" class="col-xs-2 col-form-label">NBM</label>
      <div class="col-xs-10">
        <input name="nbm" class="form-control" type="text" value="{{ $user->nbm }}" id="textInput">
      </div>
    </div>

    <div class="form-group row">
      <label for="textInput" class="col-xs-2 col-form-label">Alamat</label>
      <div class="col-xs-10">
        <input name="alamat" class="form-control" type="text" value="{{ $user->alamat }}" id="textInput">
      </div>
    </div>

    <div class="form-group row">
      <label for="textInput" class="col-xs-2 col-form-label">Telepon</label>
      <div class="col-xs-10">
        <input name="phone" class="form-control" type="text" value="{{ $user->phone }}" id="textInput">
      </div>
    </div>
    
    @if(! $noadmin == 'noadmin')
    <div class="form-group row">
      <label for="textInput" class="col-xs-2 col-form-label">Instansi *</label>
      <div class="col-xs-10">
        <select name="aum_list_id" class="form-control" required>
          @if(isset($user->aumList->id))
            <option value="{{ $user->aumList->id }}">{{ $user->aumList->name }}</option>
          @endif
          <option value="0">Belum ada</option>
          @foreach($aums as $aum)
          <option value="{{ $aum->id }}">{{ $aum->name }}</option>
          @endforeach
        </select>
        <small class="form-text text-muted">Instansi Baru? Tambahkan <a href="{{ url('admin/kelola/aum/add') }}">disini</a></small>
      </div>
    </div>
    @endif

    <br>
    <div class="alert alert-info">
      <h6>Informasi Login</h6>
    </div>

    <div class="form-group row">
      <label for="textInput" class="col-xs-2 col-form-label">Email *</label>
      <div class="col-xs-10">
        <input name="email" class="form-control" type="email" value="{{ $user->email }}" id="textInput" required>
        <span class="form-text text-muted"><a id="showPasswordField" href="javascript:void">Ubah Password?</a></span>
      </div>
    </div>

    <div id="changePassword" class="form-group row">
      <label for="textInput" class="col-xs-2 col-form-label">Password *</label>
      <div class="col-xs-10">
        <input id="password" name="password" class="form-control" type="password" value="" id="textInput">
        <span class="form-text text-muted"><a id="hidePasswordField" href="javascript:void">Password tetap</a></span>
      </div>
    </div>

    @if(! $noadmin == 'noadmin')
    <div class="form-group row">
      <label for="textInput" class="col-xs-2 col-form-label">Level *</label>
      <div class="col-xs-10">
        <select name="level" class="form-control" required>
          <option value="{{ $user->level }}">{{ $user->level }}</option>
          @foreach($levels as $level)
            <option value="{{ $level }}">{{ $level }}</option>
          @endforeach
        </select>
      </div>
    </div>
    @endif

    
    @if(! $noadmin == 'noadmin')
    <div class="form-group row">
      <label for="textInput" class="col-xs-2 col-form-label">Status *</label>
      <div class="col-xs-10">
        <select name="status" class="form-control" required>
          <option value="{{ $user->is_active }}">{{ $stat[$user->is_active] }}</option>
          @foreach($statuses as $status)
            <option value="{{ $status }}">{{ $stat[$status] }}</option>
          @endforeach
        </select>
      </div>
    </div>
    @endif

    <div align="center">
      <button type="submit" class="btn btn-lg btn-primary">Simpan Perubahan</button>
      <button type="reset" class="btn btn-lg btn-secondary">Reset</button>
    </div>
  </form>

  @push('jscode')
    <script type="text/javascript">
      $(document).ready(function (){
        $("#changePassword").hide();
      });
      // Toggle password hide
      $("#showPasswordField").click( function(){
        $("#changePassword").toggle();
        $("#showPasswordField").toggle();
      });
      $("#hidePasswordField").click( function(){
        $("#changePassword").toggle();
        $("#showPasswordField").toggle();
        $("#password").val('');
      });      
    </script>
  @endpush
@endsection
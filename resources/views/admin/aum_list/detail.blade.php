@extends('layouts.admin')
@section('title', 'Kelola Sub Situs ')
@section('content')
@push('csscode')
  <style type="text/css">
    #gmaps-canvas {
      min-height: 300px;
      width: 100%;
    }
  </style>
@endpush
  {{-- Jumbotron --}}
  <div class="jumbotron py-1">
    <h2>Detail Sub Situs <span class="fa fa-sitemap float-xs-right"></span></h2>
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


  <form action="#" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="id" value="{{ $aum->id }}">
    <div class="form-group row">
      <label for="textInput" class="col-xs-2 col-form-label">Nama *</label>
      <div class="col-xs-10">
        <input name="name" class="form-control" type="text" value="{{ $aum->name }}" id="textInput" placeholder="Nama Amal Usaha" disabled>
      </div>
    </div>

    <div class="form-group row">
      <label for="textInput" class="col-xs-2 col-form-label">Alamat * <small><br>(dan Koordinat Google Map)</small></label>
      <div class="col-xs-10">
        <textarea name="address" rows="3" class="form-control" id="textInput" disabled>{{ $aum->address }}</textarea>
        <br>
        <input name="gmap_lat" class="form-control" type="text" value="{{ $aum->gmap_lat }}" id="textInput" placeholder="Latitude GMAPS" disabled>
        <br>
        <input name="gmap_lng" class="form-control" type="text" value="{{ $aum->gmap_lng }}" id="textInput" placeholder="Longtitude GMAPS" disabled>        
      </div>
    </div>

    <div class="form-group row">
      <label for="textInput" class="col-sm-2 col-form-label hidden-xs-down">Lokasi Map</label>
      <div class="col-sm-10 col-xs-12">
        <div id="gmaps-canvas" class="col-sm-10 col-xs-12"></div>
      </div>
    </div>    

    <div class="form-group row">
      <label for="textInput" class="col-xs-2 col-form-label">Kontak *</label>
      <div class="col-xs-10">
        <input name="contact" class="form-control" type="text" value="{{ $aum->contact }}" id="textInput" placeholder="Nomor Kantor/ HP" disabled>
      </div>
    </div>

    <div align="center">
      <a href="{{ url('admin/kelola/aum/edit/'.$aum->id) }}" class="btn btn-lg btn-primary">Ubah</a>&nbsp;
      <button type="button" onclick="history.back()" class="btn btn-lg btn-secondary">Kembali</button>
    </div>

    <br><br><hr>
    <div class="row">
      <div class="col-xs-2">Staff dalam {{ $aum->name }}</div>
      <div class="col-xs-10">
        @foreach($aum->user as $user)
        <?php
            // Check user status
            if($user->is_active == 0)
            {
              $status = 'non-aktif';
            }
            elseif($user->is_active == 1)
            {
              $status = 'aktif';
            }
            else {$status = 'tidak terdefinisi';}        
        ?>
        <small><a onclick="detailUser({{ $user->id }}, '{{ $user->name }}')" href="javascript:void">{{ $user->name }}</a> - ({{ $status }})</small> <br>
        @endforeach        
      </div>
    </div>
  </form>

  @push('modalcode')
    <!-- Large modal -->
    <div class="modal fade detailUser" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Loading</h4>
          </div>
          <div class="modal-body">
            <div id="myModalContent">
            Loading
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          </div>
        </div> {{-- // Modal Content --}}
      </div>
    </div>
    <!-- EOF Large modal -->
  @endpush

  @push('jscode')
    <script type="text/javascript">
      // Detail ajax function
      function detailUser(id, name){
        $.ajax({
            method: 'POST',
            url: '{{ url("admin/kelola/pengguna/detail") }}',
            beforeSend: function (xhr) {
              return xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
            },
            data: {
                id: id,
             },
            success:function(data){
                $("#myModalLabel").text('Data - '+name);
                $("#myModalContent").html('Loading Data - '+name);
                $(".modal.detailUser").modal('show');
                $("#myModalContent").html(data);
                // alert(data);
                // datatable.ajax.reload();
            },error:function(data){
                alert("Terjadi kesalahan: "+data);
            }
        });
      };    
    </script>  
    <script src="http://maps.google.com/maps/api/js?key={{ env('GOOGLE_APIKEY') }}&language=id&region=ID"></script>
    <script src="{{ URL::asset('assets/gmap/gmaps.min.js') }}"></script>
    <script type="text/javascript">
    // Arsyfa Hijab Lat, Lng
    var map = new GMaps({
      div: '#gmaps-canvas',
      lat: {{ $aum->gmap_lat }},
      lng: {{ $aum->gmap_lng }},
      zoom: 18
    }); // var GMaps

    map.addMarker({
      lat: {{ $aum->gmap_lat }},
      lng: {{ $aum->gmap_lng }},
      title: '{{ $aum->name }}',
      infoWindow: {
        content: '{{ $aum->name }}'
      }
      // ,click: function(e) {
      //   alert('You clicked in this marker');
      // }
    }); // map.addMarker   
  </script>
  @endpush

@endsection
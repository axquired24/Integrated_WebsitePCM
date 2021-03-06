@extends('layouts.admin')
@section('title', 'Kelola Pengumuman ')
@section('content')
  {{-- Jumbotron --}}
  <div class="jumbotron py-1">
    <h2>Kelola Pengumuman</h2>
    <p>Halaman ini berisi daftar Pengumuman {{ $aum->name }}. <br><br>
    <a href="{{ url('admin/kelola/artikel/add/pengumuman') }}" class="btn btn-danger"><span class="fa fa-plus-circle hidden-xs-down"></span> Tambah Pengumuman</a>
    <a href="#" class="btn btn-outline-primary hidden-sm-up" data-toggle="offcanvas"><span class="fa fa-navicon"></span> Buka Menu</a>
    </p>
  </div>
  {{-- EOF Jumbotron --}}


  <div class="row">
    <div class="col-xs-12">
      <table class="table table-hover table-bordered" id="datatable">
        <thead class="thead-default">
          <th>No</th>
          <th>Judul</th>
          <th>Penulis</th>
        </thead>
      </table>
    </div><!--/span-->
  </div><!--/row-->

@push('jscode')
<script>
// Side bar css
$(document).ready(function (){
  // $("input[type=search]").addClass('form-control');
  $("input[type=search]").attr({'placeholder': ' Ketik sesuatu'});
  $("input[type=search]").css({'border': 'rgba(0,0,0,0.5) 2px solid'});

  // $("select[name=datatable_length]").addClass('form-control');
  // $("select[name=datatable_length]").addClass('d-inline');
});

// Datatable View
var datatable =
$('#datatable').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{{ url("admin/kelola/artikel/pengumuman/getdata/") }}',
    columns: [
        { data: 'rownum', name: 'rownum', searchable: false },
        { data: 'title', name: 'title' },
        { data: 'user_name', name: 'user_name' }
    ],
    order: [ [0, 'desc'] ]
});

// Cast ajax function
function setCastBtn(id, title){
  var confirmed   = confirm('Broadcast Pengumuman : '+title +' ?');
  if(confirmed == true){
    $.ajax({
        method: 'POST',
        url: '{{ url("admin/kelola/artikel/setCast") }}',
        beforeSend: function (xhr) {
          return xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
        },
        data: {
            id: id,
         },
        success:function(data){
            alert(data);
            datatable.ajax.reload();
        },error:function(data){
            alert("Terjadi kesalahan: "+data);
        }
    });
  } // if confirmed true
};

// Cast ajax function
function unsetCastBtn(id, title){
  var confirmed   = confirm('Copot Broadcast : '+title +' ?');
  if(confirmed == true){
    $.ajax({
        method: 'POST',
        url: '{{ url("admin/kelola/artikel/unsetCast") }}',
        beforeSend: function (xhr) {
          return xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
        },
        data: {
            id: id,
         },
        success:function(data){
            alert(data);
            datatable.ajax.reload();
        },error:function(data){
            alert("Terjadi kesalahan: "+data);
        }
    });
  } // if confirmed true
};

// Delete ajax function
function deleteBtn(id, title){
  var confirmed   = confirm('Hapus Artikel: '+title +' ?');
  if(confirmed == true){
    $.ajax({
        method: 'POST',
        url: '{{ url("admin/kelola/artikel/delete") }}',
        beforeSend: function (xhr) {
          return xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
        },
        data: {
            id: id,
         },
        success:function(data){
            alert(data);
            datatable.ajax.reload();
        },error:function(data){
            alert("Terjadi kesalahan: "+data);
        }
    });
  } // if confirmed true
};
</script>
@endpush
@endsection
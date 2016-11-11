@extends('layouts.admin')
@section('title', 'Kelola Pengguna ')
@section('content')
  {{-- Jumbotron --}}
  <div class="jumbotron py-1">
    <h2>Kelola Pengguna</h2>
    <p>Halaman ini berisi daftar pengguna yang ada di Website PCM Kartasura dan Sub situsnya. <br><br>
    <a href="{{ url('admin/kelola/pengguna/add') }}" class="btn btn-danger"><span class="fa fa-plus-circle hidden-xs-down"></span> Tambah Pengguna</a>
    <a href="#" class="btn btn-outline-primary hidden-sm-up" data-toggle="offcanvas"><span class="fa fa-navicon"></span> Buka Menu</a>
    </p>
  </div>
  {{-- EOF Jumbotron --}}


  <div class="row">
    <div class="col-xs-12">
      <table class="table table-hover table-bordered" id="datatable">
        <thead class="thead-default">
          <th>No</th>
          <th>Nama</th>
          <th>Level</th>
        </thead>
      </table>
    </div><!--/span-->
  </div><!--/row-->

@push('modalcode')
  <!-- Large modal -->
  <div class="modal fade detail" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
    ajax: '{{ url("admin/kelola/pengguna/getdata/") }}',
    columns: [
        { data: 'rownum', name: 'rownum', searchable: false },
        { data: 'name', name: 'name' },
        { data: 'level', name: 'level' }
    ]
});

// Detail ajax function
function detail(id, name){
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
          $(".modal.detail").modal('show');
          $("#myModalContent").html(data);
          // alert(data);
          // datatable.ajax.reload();
      },error:function(data){
          alert("Terjadi kesalahan: "+data);
      }
  });
};

// Detail ajax function
function deleteBtn(id, name){
  var confirmed   = confirm('Hapus Pengguna '+name +' ?');
  if(confirmed == true){
    $.ajax({
        method: 'POST',
        url: '{{ url("admin/kelola/pengguna/delete") }}',
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
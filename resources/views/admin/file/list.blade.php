@extends('layouts.admin')
@section('title', 'Kelola File ')
@section('content')
  {{-- Jumbotron --}}
  <div class="jumbotron py-1">
    <h2>Kelola File</h2>
    <p>Berikut daftar file yang telah diupload oleh situs ini. <br><br>
    <a href="{{ url('admin/file/add') }}" class="btn btn-danger"><span class="fa fa-plus-circle hidden-xs-down"></span> Tambah File</a>
    <a href="#" class="btn btn-outline-primary hidden-sm-up" data-toggle="offcanvas"><span class="fa fa-navicon"></span> Buka Menu</a>
    </p>
  </div>
  {{-- EOF Jumbotron --}}

  <div class="row">
    <div class="col-xs-12">
      <table class="table table-hover table-bordered" id="datatable">
        <thead class="thead-default">
          <th>No</th>
          <th>Judul File</th>
          <th>Opsi</th>
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
    ajax: '{{ url("admin/file/getdata") }}',
    columns: [
        { data: 'rownum', name: 'rownum', searchable: false },
        { data: 'title', name: 'title' },
        { data: 'action', name: 'action' }
    ],
    order: [ [0, 'desc'] ]
});


// Add ajax function
function editBtn(id, name){
  var newName   = prompt('Ubah judul file?: ', name);
  if(newName != null)
  {
    $.ajax({
        method: 'POST',
        url: '{{ url("admin/file/edit") }}',
        beforeSend: function (xhr) {
          return xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
        },
        data: {
            id: id,
            title: newName,
         },
        success:function(data){
            alert(data);
            datatable.ajax.reload();
        },error:function(data){
            alert("Terjadi kesalahan: "+data);
        }
    });
  } // if not null
};

// Detail ajax function
function deleteBtn(id, name){
  var confirmed   = confirm('Hapus File '+name +'?');
  if(confirmed == true){
    $.ajax({
        method: 'POST',
        url: '{{ url("admin/file/delete") }}',
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
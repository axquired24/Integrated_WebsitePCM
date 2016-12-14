@extends('layouts.admin')
@section('title', 'Kelola Kustom Halaman ')
@section('content')
  {{-- Jumbotron --}}
  <div class="jumbotron py-1">
    <h2>Kustom Halaman</h2>
    <p>Kelola kustom halaman yang akan tampil saat menu di klik, misalkan untuk visi misi, profil, informasi PSB dan sebagainya yang bersifat statis dari situs {{ $aum->name }}. <br><br>
    <a href="{{ url('admin/halaman/add') }}" class="btn btn-danger"><span class="fa fa-plus-circle hidden-xs-down"></span> Tambah Halaman</a>
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
          <th>Terakhir diperbarui</th>
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
    ajax: '{{ url("admin/halaman/getdata/") }}',
    columns: [
        { data: 'rownum', name: 'rownum', searchable: false },
        { data: 'title', name: 'title' },
        { data: 'updated_at', name: 'updated_at' }
    ],
    order: [ [0, 'desc'] ]
});

// Detail ajax function
function deleteBtn(id, title){
  var confirmed   = confirm('Hapus Halaman: '+title +' ?');
  if(confirmed == true){
    $.ajax({
        method: 'POST',
        url: '{{ url("admin/halaman/delete") }}',
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
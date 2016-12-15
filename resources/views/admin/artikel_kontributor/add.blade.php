@extends('layouts.admin')
@section('title', 'Tambah Artikel [Draft]')
@section('content')
@push('csscode')
    {{-- <link rel="stylesheet" href="{{ url('assets/ckeditor_basic/samples/css/samples.css') }}"> --}}
    <link rel="stylesheet" href="{{ url('assets/ckeditor_basic/samples/toolbarconfigurator/lib/codemirror/neo.css') }}">
    <style>
        .form-group .label {
            cursor: pointer;
        }
    </style>
@endpush

  {{-- {{ dd($pengumuman) }} --}}

  {{-- Jumbotron --}}
  <div class="jumbotron py-1">
    <h2>Tambah Artikel <span class="fa fa-newspaper-o float-xs-right"></span>
    </h2>
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

  <form action="{{ url('admin/kelola/artikelKontributor/add') }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="form-group row">
      <label for="textInput" class="col-xs-2 col-form-label">Judul</label>
      <div class="col-xs-10">
        <input name="title" class="form-control" type="text" value="{{ old('title') }}" id="textInput" required>
      </div>
    </div>

    <div class="form-group row">
      <label for="textInput" class="col-xs-2 col-form-label">Tujuan Publikasi</label>
      <div class="col-xs-10">
        <select name="aum_id" id="aum_id" class="form-control" onchange="getArCategory()" required>
          <option value="">Pilih Situs</option>
          @foreach($aumLists as $aumList)
            <option value="{{ $aumList->id }}">{{ $aumList->name }}</option>
          @endforeach
        </select>
      </div>
    </div>

    <div class="form-group row">
      <label for="textInput" class="col-xs-2 col-form-label">Kategori</label>
      <div class="col-xs-10">
        <select name="article_category_id" id="articleCategoryForm" class="form-control" required>
          <option value="">Pilihan Tujuan Situs dulu</option>
        </select>
      </div>
    </div>

    <div class="form-group row">
      <label for="textInput" class="col-xs-2 col-form-label">Konten</label>
      <div class="col-xs-10">
        <textarea id="editor" name="content" rows="5" class="form-control" type="text" required>{{ old('content') }}</textarea>
      </div>
    </div>

    <div class="form-group row">
      <label for="textInput" class="col-xs-2 col-form-label">Gambar</label>
      <div class="col-xs-10">
        <input id="image_file" name="file" class="form-control" type="file" required>
      </div>
    </div>

    <div align="center">
      <button type="submit" class="btn btn-lg btn-primary">Kirim</button>
    </div>
  </form>

@push('jscode')
  <script src="{{ url('assets/ckeditor_basic/ckeditor.js') }}"></script>
  <script src="{{ url('assets/ckeditor_basic/config.js') }}"></script>
  <script src="{{ url('assets/ckeditor_basic/samples/js/sample.js') }}"></script>
  <script>
      initSample();
      $("#image_file").attr({'accept' : '.jpg, .png, .jpeg'})
      $("#menu-artikel").addClass("active");

      function getArCategory () {
        var aumVal   = $('#aum_id').val();
        if(aumVal != '') {
          $.ajax({
              method: 'POST',
              url: '{{ url("admin/kelola/artikelKontributor/getArCategory") }}',
              beforeSend: function (xhr) {
                return xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
              },
              data: {
                  aum_id: aumVal,
               },
               dataType: 'json',
              success:function(data){
                var catName   = '';
                $.each(data, function(dkey, dvalue) {
                  catName   += '<option value="'+dvalue.id+'">'+dvalue.name+'</option>';
                });
                $('#articleCategoryForm').html(catName);
                // console.log(data);
              },error:function(data){
                  alert("Terjadi kesalahan: "+data);
              }
          });
        } // EOF IF
      }
  </script>
@endpush

@endsection
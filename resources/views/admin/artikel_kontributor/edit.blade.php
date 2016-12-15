@extends('layouts.admin')
@section('title', 'Edit Artikel [Draft]')
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
    <h2>Edit Artikel <span class="fa fa-newspaper-o float-xs-right"></span>
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

  <form action="{{ url('admin/kelola/artikelKontributor/edit') }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <input type="hidden" name="id" value="{{ $artikel->id }}">
    <div class="form-group row">
      <label for="textInput" class="col-xs-2 col-form-label">Judul</label>
      <div class="col-xs-10">
        <input name="title" class="form-control" type="text" value="{{ $artikel->title }}" id="textInput" required>
      </div>
    </div>

    <div class="form-group row">
      <label for="textInput" class="col-xs-2 col-form-label">Tujuan Publikasi</label>
      <div class="col-xs-10">
        <select name="aum_id" id="aum_id" class="form-control" onchange="getArCategory()" required>
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
          @foreach($arCategories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
          @endforeach
        </select>
      </div>
    </div>

    <div class="form-group row">
      <label for="textInput" class="col-xs-2 col-form-label">Konten</label>
      <div class="col-xs-10">
        <textarea id="editor" name="content" rows="5" class="form-control" type="text" required>{!! $artikel->content !!}</textarea>
      </div>
    </div>

    <div class="form-group row">
      <label for="textInput" class="col-xs-2 col-form-label">Gambar</label>
      <div class="col-xs-10" id="image-viewer">
        <img class="img-fluid" src="{{ URL::asset('files/artikel/'.$artikel->articleCategory->aum_list_id.'/thumb-'.$artikel->image_path) }}" alt="Gambar - {{ $artikel->title }}"> <br><a href="javascript:" id="showField">Ganti gambar</a>
      </div>
      <div class="col-xs-10" id="image-browser">
        <input id="image_file" name="file" class="form-control" type="file">
        <div class="form-text"><a href="javascript:void" id="hideField">Tetap gambar lama</a></div>
      </div>
    </div>

    <div align="center">
      <button type="submit" class="btn btn-lg btn-primary">Simpan Perubahan</button> 
      <a href="{{ url('admin') }}" class="btn btn-lg btn-secondary">Batal</a>
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
      $('#aum_id').val('{{ $artikel->articleCategory->aum_list_id }}');
      $('#articleCategoryForm').val('{{ $artikel->articleCategory->id }}');

      // Toggle Hide/show image-browser
      $("#image-browser").hide();
      $("#image-viewer").show();

      $("#showField").click( function(){
        $("#image-viewer").toggle();
        $("#image-browser").toggle();
        $("#image_file").attr({'required':''})
      });
      $("#hideField").click( function(){
        $("#image-viewer").toggle();
        $("#image-browser").toggle();
        $("#image_file").val('')
        $("#image_file").removeAttr('required')
      });

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
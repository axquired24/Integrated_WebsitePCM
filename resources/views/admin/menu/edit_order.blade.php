@extends('layouts.admin')
@section('title', 'Susun menu ')
@section('content')
@push('csscode')
    <link rel="stylesheet" href="{{ url('assets/nestable/nestable.css') }}">
    <style>
        .form-group .label {
            cursor: pointer;
        }
    </style>
@endpush

  {{-- Jumbotron --}}
  <div class="jumbotron py-1">
    <h2>Susun letak menu <span class="fa fa-columns float-xs-right"></span></h2>
    <p>Sesuaikan letak menu (Navigasi {{ $aum->name }}) dengan cara tahan dan tempel (drag & drop) pada posisi yang diinginkan, kemudian tekan simpan.</p>
  </div>
  {{-- EOF Jumbotron --}}

  {{-- Nestable --}}
  <menu id="nestable-menu">
      <button class="btn btn-primary hidden-xs-down" type="button" data-action="expand-all">Buka Sub</button>
      <button class="btn btn-outline-primary hidden-xs-down" type="button" data-action="collapse-all">Tutup Sub</button>
      <a title="Tabel Menu" href="{{ url('admin/menu/dtable') }}" class="btn btn-outline-danger hidden-xs-down"><span class="fa fa-table"></span></a>
      <a href="{{ url('admin/menu/add') }}" class="btn btn-danger pull-right"><span class="fa fa-plus-circle hidden-xs-down"></span> Tambah Menu</a><br>
  </menu>
  <div class="cf nestable-lists">
      {{-- <div class="dd" id="nestable2">
      </div> --}}
      <div class="dd" id="nestable">
          <ol class="dd-list">

          @if($aum->menu_order == '')
          {{-- If nothing set to aum->menu_order --}}

            @foreach($menus as $menu)
            {{-- Display all menu on same level --}}
              <li class="dd-item" data-id="{{ $menu->id }}">
                  <div class="dd-handle">
                    <span class="fa fa-navicon bg-primary text-white"></span>&nbsp; {{ $menu->name }}
                    <a class="text-danger pull-right" title="Hapus menu" href="#"><span class="fa fa-trash"></span></a>
                    <a class="pull-right" title="Edit menu" href="#"><span class="fa fa-pencil"></span>&nbsp;&nbsp;</a>
                  </div>
              </li>
            @endforeach

          @else
          {{-- Else, aum->menu_order is set. Display menu based on level set --}}
            <?php
              // Set Serialize
              $serialize  = json_decode($aum->menu_order);
            ?>
            @foreach($serialize as $key => $value)

              @if(isset($value->children))
                {{-- // Echo Level 1 with </li> : $value>id--}}
                <?php $menu = App\Models\Menu::find($value->id); ?>
                <li class="dd-item" data-id="{{ $menu->id }}">
                  <div class="dd-handle">
                    <span class="fa fa-navicon bg-primary text-white"></span>&nbsp; {{ $menu->name }}
                    <a class="text-danger pull-right" title="Hapus menu" href="#"><span class="fa fa-trash"></span></a>
                    <a class="pull-right" title="Edit menu" href="#"><span class="fa fa-pencil"></span>&nbsp;&nbsp;</a>
                  </div>
                  <ol class="dd-list">
                    @foreach($value->children as $keychildren => $valuechildren)
                      {{-- // Level 2 : $valuechildren->id --}}
                        <?php $submenu = App\Models\Menu::find($valuechildren->id); ?>
                        <li class="dd-item" data-id="{{ $submenu->id }}">
                          <div class="dd-handle">
                            <span class="fa fa-navicon bg-primary text-white"></span>&nbsp; {{ $submenu->name }}
                            <a class="text-danger pull-right" title="Hapus menu" href="#"><span class="fa fa-trash"></span></a>
                            <a class="pull-right" title="Edit menu" href="#"><span class="fa fa-pencil"></span>&nbsp;&nbsp;</a>
                          </div>
                        </li>
                    @endforeach
                  </ol>
                  </li>

              @else
                {{-- // Echo Level 1 : $value>id--}}
                <?php $menu = App\Models\Menu::find($value->id); ?>
                <li class="dd-item" data-id="{{ $menu->id }}">
                  <div class="dd-handle">
                    <span class="fa fa-navicon bg-primary text-white"></span>&nbsp; {{ $menu->name }}
                    <a class="text-danger pull-right" title="Hapus menu" href="#"><span class="fa fa-trash"></span></a>
                    <a class="pull-right" title="Edit menu" href="#"><span class="fa fa-pencil"></span>&nbsp;&nbsp;</a>
                  </div>
                </li>
              @endif
              {{-- EOF @if(isset($value->children)) --}}
            @endforeach
            {{-- EOF @foreach($value->children as $keychildren => $valuechildren) --}}
          @endif
          {{-- EOF if($aum->menu_order == '') --}}
          </ol>
      </div>

  </div>

  <p><strong>Serialised Output (per list)</strong></p>

  <form action="{{ url('admin/menu/editOrder') }}" method="post">
  {{ csrf_field() }}
  <?php
    $menu_order = '';
    if($aum->menu_order != '')
    {
      $menu_order = $aum->menu_order;
    }
  ?>
  <textarea name="menu_order" id="nestable-output"></textarea>
  {{-- <textarea id="nestable2-output"></textarea> --}}

  <!-- <p class="small">Nestable &copy; <a href="http://dbushell.com/">David Bushell</a> | Made for <a href="http://www.browserlondon.com/">Browser</a></p> -->
  {{-- EOF Nestable --}}

  <div align="center">
    <button type="submit" class="btn btn-lg btn-primary">Simpan</button>
    <input onclick="return confirm('Reset Susunan?')" name="resetMenu" type="submit" class="btn btn-lg btn-secondary" value="Reset Susunan">
  </div>
  </form>

  @push('jscode')
    <script type="text/javascript" src="{{ URL::asset('assets/nestable/jquery.nestable.js') }}"></script>
    <script>
      $(document).ready(function()
      {
        var updateOutput = function(e)
        {
            var list   = e.length ? e : $(e.target),
                output = list.data('output');
            if (window.JSON) {
                output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
            } else {
                output.val('JSON browser support required for this demo.');
            }
        };

        // activate Nestable for list 1
        $('#nestable').nestable({
            group: 1,
            maxDepth: 2,
        })
        .on('change', updateOutput);

        // activate Nestable for list 2
        // $('#nestable2').nestable({
        //     group: 1,
        //     maxDepth: 3,
        // })
        // .on('change', updateOutput);

        // output initial serialised data
        updateOutput($('#nestable').data('output', $('#nestable-output')));
        // updateOutput($('#nestable2').data('output', $('#nestable2-output')));

        $('#nestable-menu').on('click', function(e)
        {
            var target = $(e.target),
                action = target.data('action');
            if (action === 'expand-all') {
                $('.dd').nestable('expandAll');
            }
            if (action === 'collapse-all') {
                $('.dd').nestable('collapseAll');
            }
        });

        $('#nestable3').nestable();
      });
    </script>
  @endpush

@endsection
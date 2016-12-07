@if(isset($aum))
@if($aum->menu_order == '')
  {{-- If nothing set to aum->menu_order --}}
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Menu <span class="caret"></span>
        </a>
        <div class="dropdown-menu">
            @foreach($menus as $menu)
            {{-- Display all menu on same level --}}
                <a class="dropdown-item" href="{{ $menu->link }}"><span class="fa fa-chevron-right"></span> &nbsp;{{ $menu->name }}</a>
            @endforeach
        </div>
    </li>

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
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ $menu->name }} <span class="caret"></span>
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{ $menu->link }}">{{ $menu->name }}</a>
                @foreach($value->children as $keychildren => $valuechildren)
                  {{-- // Level 2 : $valuechildren->id --}}
                    <?php $submenu = App\Models\Menu::find($valuechildren->id); ?>
                    <a class="dropdown-item" href="{{ $submenu->link }}">{{ $submenu->name }}</a>
                @endforeach
                </div>
            </li>

      @else
        {{-- // Echo Level 1 : $value>id--}}
        <?php $menu = App\Models\Menu::find($value->id); ?>
        <li class="nav-item"><a class="nav-link" href="{{ $menu->link }}">{{ $menu->name }}</a></li>
      @endif
      {{-- EOF @if(isset($value->children)) --}}
    @endforeach
    {{-- EOF @foreach($value->children as $keychildren => $valuechildren) --}}
@endif
{{-- EOF if($aum->menu_order == '') --}}

@else 
{{-- else -  isset($aum) --}}
  <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
@endif
{{-- EOF isset($aum) --}}
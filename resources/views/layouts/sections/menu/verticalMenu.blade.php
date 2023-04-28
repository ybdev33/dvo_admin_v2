<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

  <!-- ! Hide app brand if navbar-full -->
  <div class="app-brand demo">
    <a href="{{url('/')}}" class="app-brand-link">
      <span class="app-brand-logo demo">
        <img src="{{ asset('assets/img/icons/play.png') }}" alt class="w-px-40 h-auto">
      </span>
      <span class="app-brand-text demo menu-text fw-bold ms-2">{{config('variables.templateName')}}</span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-autod-block d-xl-none">
      <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <?php
  $user = session()->get('user');
  $menu = $user->module;
  // $menu[] = (object) ['moduleName' => 'Settings'];
  //  echo "<pre>";
  //  print_r($menu);
  //  echo "</pre>";
  //  die('ee');

  //  $menu[]['settings'] = [
  //   'name' => 'Settings',
  //   'icon' => 'menu-icon tf-icons bx bx-cog',
  //   'url'  => 'settings',
  //   'slug' => 'settings'
  //  ];

  # !TODO checking not existing array
  $icon['dashboard'] = 'menu-icon tf-icons bx bx-home-circle';
  $icon['hits'] = 'menu-icon tf-icons bx bx-crown';
  $icon['cancel-bets'] = 'menu-icon tf-icons bx bx-collection';
  $icon['users'] = 'menu-icon tf-icons bx bx bx-user-circle';
  $icon['reports'] = 'menu-icon tf-icons bx bx-cube-alt';
  $icon['sold-outs'] = 'menu-icon tf-icons bx bx-border-outer';
  $icon['approval'] = 'menu-icon tf-icons bx bx-wallet';
  $icon['expenses'] = 'menu-icon tf-icons bx bx-wallet';
  // $icon['settings'] = 'menu-icon tf-icons bx bx-cog';

  $menuData = array();
  foreach ($menu as $item) {
    foreach ($item as $key => $value) {
      $slug = Str::slug($value, '-');
      // condition for expenses of Super Admin and Admin only!!!
      if( $slug === "expenses" && ($user->position === "Super Admin" || $user->position === "Admin") )
        $slug = "approval";

      $menuData['menu'][] = (object) [
        'name' => $value,
        'icon' => $icon[$slug] ?? '',
        'url'  => $slug,
        'slug' => $slug
      ];
    }
  }
  $menuData = (object) $menuData;

  // echo "<pre>";
  // print_r($menuData);
  // echo "</pre>";
  // die();
  ?>

  <ul class="menu-inner py-1">
    @foreach ($menuData->menu as $menu)

    {{-- adding active and open class if child is active --}}

    {{-- active menu method --}}
    @php
    $activeClass = null;
    $currentRouteName = Route::currentRouteName();

    $routes = \Str::of(\Route::currentRouteName())->explode('.')[0];
    //echo $routes .' === '. $menu->slug;
    if( $menu->slug === "approval" )
      $menu->slug = "expenses";
    if ($routes === $menu->slug) {
    $activeClass = 'active';
    }
    elseif ($currentRouteName === $menu->slug) {
    $activeClass = 'active';
    }
    elseif (isset($menu->submenu)) {
    if (gettype($menu->slug) === 'array') {
    foreach($menu->slug as $slug){
    if (str_contains($currentRouteName,$slug) and strpos($currentRouteName,$slug) === 0) {
    $activeClass = 'active open';
    }
    }
    }
    else{
    if (str_contains($currentRouteName,$menu->slug) and strpos($currentRouteName,$menu->slug) === 0) {
    $activeClass = 'active open';
    }
    }

    }
    @endphp

    {{-- main menu --}}
    <li class="menu-item {{$activeClass}}">
      <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}" class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}" @if (isset($menu->target) and !empty($menu->target)) target="_blank" @endif>
        @isset($menu->icon)
        <i class="{{ $menu->icon }}"></i>
        @endisset
        <div>{{ isset($menu->name) ? __($menu->name) : '' }}</div>
      </a>

      {{-- submenu --}}
      @isset($menu->submenu)
      @include('layouts.sections.menu.submenu',['menu' => $menu->submenu])
      @endisset
    </li>

    @endforeach
  </ul>

</aside>
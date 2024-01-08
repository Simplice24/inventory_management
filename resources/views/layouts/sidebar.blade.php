<?php
// set collapsed class
function isCollapsed(array $controllerNameArray)
{
    $c_con_array = explode('.', Route::currentRouteName());
    $current_controller = $c_con_array[0];
    if (!in_array($current_controller, $controllerNameArray)) {
        echo 'collapsed';
    }
}
// set active class in li tag
function isActiveLI($controllerName)
{
    $c_con_array = explode('.', Route::currentRouteName());
    $current_controller = $c_con_array[0];
    if ($current_controller == $controllerName) {
        echo 'active';
    }
}
// set show class in a tag
function isShow($controllerName)
{
    $c_con_array = explode('.', Route::currentRouteName());
    $current_controller = $c_con_array[0];
    if ($current_controller == $controllerName) {
        echo 'show';
    }
}
// set active class
function isActive($routeName)
{
    if (Route::currentRouteName() == $routeName) {
        echo 'active';
    }
}
?>

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/') }}">
    <div class="sidebar-brand-icon rotate-n-15">
      {{-- <i class="fas fa-laugh-wink"></i> --}}
    </div>
    <div class="sidebar-brand-text mx-3">Inventory Management</div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Nav Item - Dashboard -->
  <li class="nav-item {{ isActiveLI('dashboard') }}">
    <a class="nav-link" href="{{ route('dashboard') }}">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  {{-- Nav item -users --}}
  @canany(['user-edit', 'user-list', 'user-create', 'user-delete'])
    <li class="nav-item {{ isActiveLI('users') }}">
      <a class="nav-link {{ isCollapsed(['users']) }}" href="#" data-toggle="collapse" data-target="#userMenu"
        aria-expanded="true" aria-controls="userMenu">
        <i class="fas fa-user"></i>
        <span>Users</span>
      </a>
      <div id="userMenu" class="collapse {{ isShow('users') }}" aria-labelledby="headingTwo"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header">User Components:</h6>
          @canany(['user-edit', 'user-list', 'user-delete'])
            <a class="collapse-item {{ isActive('users.index') }}" href="{{ route('users.index') }}"><i
                class="fas fa-list mr-2 text-primary"></i>Users List</a>
          @endcanany
          @can('user-create')
            <a class="collapse-item {{ isActive('users.create') }}" href="{{ route('users.create') }}"><i
                class="fas fa-plus-square mr-2 text-success"></i>Add User</a>
          @endcan
        </div>
      </div>
    </li>
  @endcanany


  {{-- Nav item -permission management --}}
  @canany(['permission-edit', 'permission-list', 'permission-create', 'permission-delete'])
    <li class="nav-item {{ isActiveLI('permissions') }}">
      <a class="nav-link {{ isCollapsed(['permissions']) }}" href="{{ route('permissions.index') }}">
        <i class="fas fa-shield-alt"></i>
        <span>Permission Management</span>
      </a>
    </li>
  @endcanany


  {{-- Nav item -role managements --}}
  @canany(['role-edit', 'role-list', 'role-create', 'role-delete'])
    <li class="nav-item {{ isActiveLI('roles') }}">
      <a class="nav-link {{ isCollapsed(['roles']) }}" href="{{ route('roles.index') }}">
        <i class="fas fa-user-shield"></i>
        <span>Role Management</span>
      </a>
    </li>
  @endcanany

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  {{-- Nav item - Raw Materials --}}
  @canany(['material-edit', 'material-list', 'material-create', 'material-delete', 'raw-req-list', 'raw-req-create',
    'raw-req-edit', 'raw-req-delete', 'raw-req-confirm'])
    <li class="nav-item {{ isActiveLI('raw-materials') }} {{ isActiveLI('raw-material-requests') }}">
      <a class="nav-link {{ isCollapsed(['raw-materials', 'raw-material-requests']) }}" href="#"
        data-toggle="collapse" data-target="#rawMaterialsMenu" aria-expanded="true" aria-controls="rawMaterialsMenu">
        <i class="fas fa-tools"></i>
        <span>Raw Materials</span>
      </a>
      <div id="rawMaterialsMenu" class="collapse {{ isShow('raw-materials') }} {{ isShow('raw-material-requests') }}"
        aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header">Raw Material Components:</h6>

          {{-- Check Raw Material Component permissions --}}
          @canany(['material-edit', 'material-list', 'material-create', 'material-delete'])
            <a class="collapse-item {{ isActive('raw-materials.index') }}" href="{{ route('raw-materials.index') }}"><i
                class="fas fa-warehouse mr-2 text-primary"></i>Inventory</a>
          @endcanany

          {{-- check raw mat request permissions --}}
          @canany(['raw-req-edit', 'raw-req-list', 'raw-req-create', 'raw-req-delete'])
            @can('raw-req-create')
              <a class="collapse-item {{ isActive('raw-material-requests.create') }}"
                href="{{ route('raw-material-requests.create') }}"><i
                  class="fas fa-plus-square mr-2 text-success"></i>Request Raw
                Material</a>
            @endcan
            @can('raw-req-list')
              <a class="collapse-item {{ isActive('raw-material-requests.index') }}"
                href="{{ route('raw-material-requests.index') }}"><i class="fas fa-history mr-2"></i>Request
                History</a>
            @endcan
          @endcanany

          {{-- users only have raw-req-confirm permission can show this --}}
          @canany(['raw-req-confirm'])
            <a class="collapse-item {{ isActive('raw-material-requests.queue-list') }}"
              href="{{ route('raw-material-requests.queue-list') }}"><i class="fas fa-list mr-2 text-warning"></i>Queue
              List</a>
          @endcanany
        </div>
      </div>
    </li>
  @endcanany

  {{-- Nav item - Production Materials --}}
  @canany(['production-edit', 'production-list', 'production-create', 'production-delete', 'production-req-list',
    'production-req-create', 'production-req-edit', 'production-req-delete', 'production-req-confirm'])
    <li class="nav-item {{ isActiveLI('production-materials') }} {{ isActiveLI('production-material-requests') }}">
      <a class="nav-link {{ isCollapsed(['production-materials', 'production-material-requests']) }}" href="#"
        data-toggle="collapse" data-target="#productionMatMenu" aria-expanded="true" aria-controls="productionMatMenu">
        <i class="fas fa-industry"></i>
        <span>Production Materials</span>
      </a>
      <div id="productionMatMenu"
        class="collapse {{ isShow('production-materials') }} {{ isShow('production-material-requests') }}"
        aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header">Prod Mat Components:</h6>

          {{-- Check Production Material Component permissions --}}
          @canany(['production-edit', 'production-list', 'production-create', 'production-delete'])
            <a class="collapse-item {{ isActive('production-materials.index') }}"
              href="{{ route('production-materials.index') }}"><i
                class="fas fa-warehouse mr-2 text-primary"></i>Inventory</a>
          @endcanany

          {{-- check Production mat request permissions --}}
          @canany(['production-req-edit', 'production-req-list', 'production-req-create', 'production-req-delete'])
            @can('production-req-create')
              <a class="collapse-item {{ isActive('production-material-requests.create') }}"
                href="{{ route('production-material-requests.create') }}"><i
                  class="fas fa-plus-square mr-2 text-success"></i>Create Request</a>
            @endcan
            @can('production-req-list')
              <a class="collapse-item {{ isActive('production-material-requests.index') }}"
                href="{{ route('production-material-requests.index') }}"><i class="fas fa-history mr-2"></i>Request
                History</a>
            @endcan
          @endcanany

          {{-- users only have production-req-confirm permission can show this --}}
          @canany(['production-req-confirm'])
            <a class="collapse-item {{ isActive('production-material-requests.queue-list') }}"
              href="{{ route('production-material-requests.queue-list') }}"><i
                class="fas fa-list mr-2 text-warning"></i>Queue
              List</a>
          @endcanany
        </div>
      </div>
    </li>
  @endcanany

  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>
</ul>

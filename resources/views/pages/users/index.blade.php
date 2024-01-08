@extends('layouts.admin')

@section('title', 'Users List')


@push('styles')
  <link href="/assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush

@push('scripts')
  <!-- Page level plugins -->
  <script src="/assets/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="/assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="/assets/js/demo/datatables-demo.js"></script>
@endpush


@section('content')
  <div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">User Management</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3 d-flex justify-content-between">
        <h5 class="m-0 font-weight-bold text-primary">Users List</h5>
        @can('user-create')
          <a class="btn btn-success" href="{{ route('users.create') }}">Create New User</a>
        @endcan
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Roles</th>
                <th>Action</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Roles</th>
                <th>Action</th>
              </tr>
            </tfoot>
            <tbody>
              @foreach ($users as $user)
                <tr>
                  <td>{{ $user->name }}</td>
                  <td>{{ $user->email }}</td>
                  <td>
                    @if (!empty($user->getRoleNames()))
                      @foreach ($user->getRoleNames() as $v)
                        <label class="badge badge-success">{{ $v }}</label>
                      @endforeach
                    @endif
                  </td>
                  <td>
                    <div class="dropdown">
                      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        @can('user-list')
                          <a class="dropdown-item" href="{{ route('users.show', $user->id) }}"><i
                              class="fa fa-eye text-primary"></i> View</a>
                        @endcan
                        @if (!$user->hasRole('Super Admin') || $user->id != Auth::user()->id)
                          @can('user-edit')
                            <a class="dropdown-item" href="{{ route('users.edit', $user->id) }}"><i
                                class="fa fa-pen text-warning"></i> Edit</a>
                          @endcan
                          @can('user-delete')
                            <form action="{{ route('users.destroy', $user->id) }}"
                              onsubmit="return confirm('Are you want to sure to delete?')" method="post">
                              @csrf
                              @method('delete')
                              <button class="dropdown-item"><i class="fa fa-trash text-danger"></i> Delete</button>
                            </form>
                          @endcan
                        @endif
                      </div>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>


@endsection

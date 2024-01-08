@extends('layouts.admin')

@section('title', 'Inventory List - Production')

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
    <h1 class="h3 mb-2 text-gray-800">Production Materials</h1>

    <!-- DataTales Example -->
    <div class="row justify-content-center">
      <div class="col-10">
        <div class="card shadow mb-4">
          <div class="card-header py-3 d-flex justify-content-between">
            <h5 class="m-0 font-weight-bold text-primary">Production Material List</h5>
            @can('production-create')
              <a href="{{ route('production-materials.create') }}" class="btn btn-primary">Add Production Material</a>
            @endcan
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Pac Size</th>
                    <th>Quantity</th>
                    <th>Created At</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Name</th>
                    <th>Pac Size</th>
                    <th>Quantity</th>
                    <th>Created At</th>
                    <th>Action</th>
                  </tr>
                </tfoot>
                <tbody>
                  @foreach ($production_materials as $item)
                    <tr>
                      <td>{{ $item->material_name }}</td>
                      <td>{{ $item->pac_size }} ltr</td>
                      <td>{{ $item->material_quantity }} {{ $item->material_quantity > 1 ? 'pieces' : 'piece' }}</td>
                      <td>{{ date('d M, Y - h:i a', strtotime($item->created_at)) }}</td>
                      <td>
                        <div class="dropdown">
                          <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                          </button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            {{-- @can('production-list')
                              <a class="dropdown-item" href="{{ route('production-materials.show', $item->id) }}"><i
                                  class="fa fa-eye text-primary"></i> View</a>
                            @endcan --}}
                            {{-- @can('production-edit')
                              <a class="dropdown-item" href="{{ route('production-materials.edit', $item->id) }}"><i
                                  class="fa fa-pen text-warning"></i> Edit</a>
                            @endcan --}}
                            @can('production-delete')
                              <form action="{{ route('production-materials.destroy', $item->id) }}"
                                onsubmit="return confirm('Are you want to sure to delete?')" method="post">
                                @csrf
                                @method('delete')
                                <button class="dropdown-item"><i class="fa fa-trash text-danger"></i> Delete</button>
                              </form>
                            @endcan
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
    </div>
  </div>
@endsection

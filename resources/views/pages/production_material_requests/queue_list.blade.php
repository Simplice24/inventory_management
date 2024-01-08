@extends('layouts.admin')

@section('title', 'Production Material Queue List')


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
    <h1 class="h3 mb-2 text-gray-800">Queue List</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h5 class="m-0 font-weight-bold text-primary">Production Material Queue List</h5>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Material Name</th>
                <th>Pack Size</th>
                <th>Quantity</th>
                <th>Requested By</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Action</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Material Name</th>
                <th>Pack Size</th>
                <th>Quantity</th>
                <th>Requested By</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Action</th>
              </tr>
            </tfoot>
            <tbody>
              @foreach ($prod_mat_reqs as $item)
                <tr>
                  <td>{{ $item->request->production_material->material_name }}</td>
                  <td>{{ $item->request->production_material->pac_size }} ltr</td>
                  <td>{{ $item->request->production_material_quantity }}
                    {{ $item->request->production_material_quantity > 1 ? 'pieces' : 'piece' }}
                  </td>
                  <td>
                    <strong>Name: </strong>{{ $item->request->requested_user->name }} <br>
                    <strong>Email: </strong>{{ $item->request->requested_user->email }}
                  </td>
                  <td>
                    <label class="badge badge-warning">{{ $status[$item->status] }}</label>
                  </td>
                  <td>{{ date('d M, Y - h:i a', strtotime($item->request->created_at)) }}</td>
                  <td>
                    <div class="dropdown">
                      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        @can('production-req-confirm')
                          {{-- confirm --}}
                          <form action="{{ route('production-material-requests.confirmation', $item->id) }}" method="post">
                            @method('put')
                            @csrf
                            <input type="text" name="status" value="1" hidden>
                            <button class="dropdown-item"><i class="fa fa-check text-success"></i> Confirm</button>
                          </form>

                          {{-- cancel --}}
                          <form action="{{ route('production-material-requests.confirmation', $item->id) }}" method="post">
                            @method('put')
                            @csrf
                            <input type="text" name="status" value="2" hidden>
                            <button class="dropdown-item"><i class="fa fa-times text-danger"></i> Cancel</button>
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
@endsection

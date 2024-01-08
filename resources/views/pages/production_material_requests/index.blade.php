@extends('layouts.admin')

@section('title', 'Production Material Request List')


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
    <h1 class="h3 mb-2 text-gray-800">Production Material Request</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
      <div class="card-header py-3 d-flex justify-content-between">
        <h5 class="m-0 font-weight-bold text-primary">Production Material Request List</h5>
        @can('production-req-create')
          <a href="{{ route('production-material-requests.create') }}" class="btn btn-primary">Create A Request</a>
        @endcan
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
                  <td>{{ $item->production_material->material_name }}</td>
                  <td>{{ $item->production_material->pac_size }} ltr</td>
                  <td>{{ $item->production_material_quantity }}
                    {{ $item->production_material_quantity > 1 ? 'pieces' : 'piece' }}</td>
                  <td>
                    <strong>Name: </strong>{{ $item->requested_user->name }} <br>
                    <strong>Email: </strong>{{ $item->requested_user->email }}
                  </td>
                  <td>
                    @if (count($item->req_confirmations) > 0)
                      <ul>
                        @foreach ($item->req_confirmations as $i)
                          <li>{{ $i->user->name }} - <label
                              class="badge badge-{{ $class_names[$i->status] }}">{{ $status[$i->status] }}</label>
                          </li>
                        @endforeach
                      </ul>
                    @else
                      <label class="badge badge-danger">No Role Assigned</label>
                    @endif
                  </td>
                  <td>{{ date('d M, Y - h:i a', strtotime($item->created_at)) }}</td>
                  <td>
                    <div class="dropdown">
                      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="{{ route('production-material-requests.show', $item->id) }}"><i
                            class="fa fa-eye text-primary"></i> View</a>

                        <?php
                        $confirmation = true;
                        foreach ($item->req_confirmations as $i) {
                            if ($i->status != 1) {
                                $confirmation = false;
                            }
                        }
                        ?>
                        @if (!$confirmation || count($item->req_confirmations) == 0)
                          @can('production-req-delete')
                            <form action="{{ route('production-material-requests.destroy', $item->id) }}"
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

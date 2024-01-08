@extends('layouts.admin')

@section('title', 'Show Production Material Request' . ' - ' . $prod_mat_req->production_material->material_name)

@push('styles')
@endpush

@push('scripts')
@endpush

@section('content')
  <div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Show Production Material Request</h1>

    <div class="row justify-content-center">
      <div class="col-6">
        <div class="card shadow mb-4">
          <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h5 class="m-0 font-weight-bold text-primary">Request Details</h5>
            @can('production-req-list')
              <a href="{{ route('production-material-requests.index') }}" class="btn btn-outline-warning">Back</a>
            @endcan
          </div>

          <div class="card-body">
            <table class="table table-striped table-hover">
              <tr>
                <th>Material Name</th>
                <td>{{ $prod_mat_req->production_material->material_name }}
                  ({{ $prod_mat_req->production_material->pac_size }} ltr)</td>
              </tr>
              <tr>
                <th>Material Quantity</th>
                <td>{{ $prod_mat_req->production_material_quantity }}
                  {{ $prod_mat_req->production_material_quantity > 1 ? 'pieces' : 'piece' }}</td>
              </tr>
              <tr>
                <th>Request Created By</th>
                <td>{{ $prod_mat_req->requested_user->name }} - ({{ $prod_mat_req->requested_user->email }})</td>
              </tr>
              <tr>
                <th>Status</th>
                <td>
                  @if (count($prod_mat_req->req_confirmations) > 0)
                    <ol>
                      @foreach ($prod_mat_req->req_confirmations as $i)
                        <li>{{ $i->user->name }} - <label
                            class="badge badge-{{ $class_names[$i->status] }}">{{ $status[$i->status] }}</label>
                          @if ($i->status == 1)
                            @ <label
                              class="badge badge-success">{{ date('d M, Y - h:i a', strtotime($i->confirmed_at)) }}</label>
                          @endif
                        </li>
                      @endforeach
                    </ol>
                  @else
                    <label class="badge badge-danger">No Role Assigned</label>
                  @endif
                </td>
              </tr>
              @if ($prod_mat_req->cancelled_user != null)
                <tr>
                  <th>Request Cancelled By</th>
                  <td>
                    {{ $prod_mat_req->cancelled_user->name }} - ({{ $prod_mat_req->cancelled_user->email }})
                    @ <label
                      class="badge badge-warning">{{ date('d M, Y - h:i a', strtotime($prod_mat_req->updated_at)) }}</label>
                  </td>
                </tr>
              @endif
              <tr>
            </table>
          </div>

          <?php
          $confirmation = true;
          foreach ($prod_mat_req->req_confirmations as $i) {
              if ($i->status != 1) {
                  $confirmation = false;
              }
          }
          ?>
          @if (!$confirmation || count($prod_mat_req->req_confirmations) == 0)
            <div class="card-footer">
              @can('production-req-delete')
                <form action="{{ route('production-material-requests.destroy', $prod_mat_req->id) }}"
                  onsubmit="return confirm('Are you want to sure to delete?')" method="post">
                  @csrf
                  @method('delete')
                  <button class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
                </form>
              @endcan
            </div>
          @endif
        </div>
      </div>

    </div>
  </div>
@endsection

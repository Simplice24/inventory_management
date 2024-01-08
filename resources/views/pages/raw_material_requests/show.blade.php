@extends('layouts.admin')

@section('title', 'Show Raw Material Request' . ' - ' . $raw_mat_req->raw_material->material_name)

@push('styles')
@endpush

@push('scripts')
@endpush

@section('content')
  <div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Show Raw Material Request</h1>

    <div class="row justify-content-center">
      <div class="col-6">
        <div class="card shadow mb-4">
          <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h5 class="m-0 font-weight-bold text-primary">Request Details</h5>
            @can('raw-req-list')
              <a href="{{ route('raw-material-requests.index') }}" class="btn btn-outline-warning">Back</a>
            @endcan
          </div>

          <div class="card-body">
            <table class="table table-striped table-hover">
              <tr>
                <th>Material Name</th>
                <td>{{ $raw_mat_req->raw_material->material_name }} ({{ $raw_mat_req->raw_material->material_type }})</td>
              </tr>
              <tr>
                <th>Material Quantity</th>
                <td>{{ $raw_mat_req->raw_material_quantity }} ({{ $raw_mat_req->raw_material->quantity_unit }})</td>
              </tr>
              <tr>
                <th>Request Created By</th>
                <td>{{ $raw_mat_req->requested_user->name }} - ({{ $raw_mat_req->requested_user->email }})</td>
              </tr>
              <tr>
                <th>Status</th>
                <td>
                  @if (count($raw_mat_req->req_confirmations) > 0)
                    <ol>
                      @foreach ($raw_mat_req->req_confirmations as $i)
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
              @if ($raw_mat_req->cancelled_user != null)
                <tr>
                  <th>Request Cancelled By</th>
                  <td>
                    {{ $raw_mat_req->cancelled_user->name }} - ({{ $raw_mat_req->cancelled_user->email }})
                    @ <label
                      class="badge badge-warning">{{ date('d M, Y - h:i a', strtotime($raw_mat_req->updated_at)) }}</label>
                  </td>
                </tr>
              @endif
              <tr>
            </table>
          </div>

          <?php
          $confirmation = true;
          foreach ($raw_mat_req->req_confirmations as $i) {
              if ($i->status != 1) {
                  $confirmation = false;
              }
          }
          ?>
          @if (!$confirmation || count($raw_mat_req->req_confirmations) == 0)
            <div class="card-footer">
              @can('raw-req-delete')
                <form action="{{ route('raw-material-requests.destroy', $raw_mat_req->id) }}"
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

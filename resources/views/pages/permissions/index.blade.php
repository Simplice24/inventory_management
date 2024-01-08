@extends('layouts.admin')

@section('title', 'Permission Management')


@push('styles')
  <link href="/assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

  <style>
    .generated-field {
      position: relative;
    }

    .item-close-btn {
      position: absolute;
      bottom: 27px;
      left: 97%;
      cursor: pointer;
    }
  </style>
@endpush

@push('scripts')
  <!-- Page level plugins -->
  <script src="/assets/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="/assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="/assets/js/demo/datatables-demo.js"></script>

  <script>
    $(document).ready(function() {
      $('.add-more-btn').click(function(event) {
        event.preventDefault();

        var fieldHTML =
          '<div class="row mt-2 generated-field"><input type="text" name="name[]" class="form-control" placeholder="item-list, item-create, item-edit, item-delete, etc"><i class="fa fa-times text-danger item-close-btn"></i></div>';

        $('.form-body').append(fieldHTML);

        $('.item-close-btn').click(function() {
          $(this).parent('div.generated-field').remove();
        });
      });
    });
  </script>
@endpush


@section('content')
  <div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Permissions Management</h1>

    <!-- DataTales Example -->
    <div class="row justify-content-center">
      <div class="col-6">
        <div class="card shadow mb-4">
          <div class="card-header py-3 d-flex justify-content-between">
            <h5 class="m-0 font-weight-bold text-primary">Permissions List</h5>
            @can('permission-create')
              <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Create New Role</button>
            @endcan
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>SL No</th>
                    <th>Permission Name</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>SL No</th>
                    <th>Permission Name</th>
                    <th>Action</th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php
                  $i = 1;
                  ?>
                  @foreach ($permissions as $item)
                    <tr>
                      <td>{{ $i++ }}</td>
                      <td>{{ $item->name }}</td>
                      <td>
                        @can('permission-delete')
                          <form action="{{ route('permissions.destroy', $item->id) }}"
                            onsubmit="return confirm('Are you want to sure to delete?')" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
                          </form>
                        @endcan
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

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 30vw">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Permission Add Form</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="raw_insert_form" action="{{ route('permissions.store') }}" method="post">
          <div class="modal-body">
            @csrf

            <label class="mb-2"><strong>Permission Name:</strong></label>
            <div class="form-body px-3">
              <div class="row">
                <input type="text" name="name[]" id="_name" class="form-control"
                  placeholder="item-list, item-create, item-edit, item-delete, etc">
              </div>
            </div>
            {{-- Add More Button --}}
            <div class="d-flex justify-content-end my-3">
              <button class="btn btn-primary add-more-btn"><i class="fa fa-plus mr-2"></i> Add More Field</button>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <input type="reset" class="btn btn-danger mr-3" value="Reset Form">
            <input id="submit-btn" type="submit" class="btn btn-success" value="Add Permissions">
          </div>
        </form>
      </div>
    </div>
  </div>


@endsection

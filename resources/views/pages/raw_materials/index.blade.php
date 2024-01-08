@extends('layouts.admin')

@section('title', 'Inventory List')

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

        var req_handler_field = $('#req_handler_role_field').html();

        var fieldHTML =
          "<div class='row mt-2 generated-field'><div class='col-3'><input type='text' name='material_name[]' class='form-control' placeholder='Bottle, Label, Oil etc.' required></div><div class='col-4'><input type='text' name='material_type[]' class='form-control' placeholder='1ltr, 5ltr, soyabean, palm etc' required></div><div class='col-2'><select name='quantity_unit[]' class='form-control' required><option value='' selected disabled>Select One</option><option value='piece'>piece</option><option value='kg'>kg</option></select></div><div class='col-3'>" +
          req_handler_field +
          "</div><i class='fa fa-times text-danger item-close-btn'></i></div>";

        $('.form-body').append(fieldHTML);

        $('.item-close-btn').click(function() {
          $(this).parent('div.generated-field').remove();
        });
      });

      // submit form
      $('#submit-btn').click(function(e) {
        // e.preventDefault();

        let myform = document.getElementById('raw_insert_form');
        let formData = new FormData(myform);

        $.ajax({
          url: "/raw-materials",
          data: formData,
          cache: false,
          processData: false,
          contentType: false,
          type: 'POST',
          success: function(response) {
            // console.log(response)
            // clear type list
            $('#errors').html('');
            var content = '';

            if (response.success) {
              location.reload();
            } else {
              // generate errors
              let errors = response.errors;
              errors.forEach(element => {
                content += '<li>' + element + '</li>';
              });
              $('#errors').html(content);
            }
          }
        });

      });

    });
  </script>
@endpush


@section('content')
  <div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Inventory</h1>

    <!-- DataTales Example -->
    <div class="row justify-content-center">
      <div class="col-8">
        <div class="card shadow mb-4">
          <div class="card-header py-3 d-flex justify-content-between">
            <h5 class="m-0 font-weight-bold text-primary">Raw Material List</h5>
            <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Add Raw Material</button>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Quantity</th>
                    <th>Created At</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Quantity</th>
                    <th>Created At</th>
                    <th>Action</th>
                  </tr>
                </tfoot>
                <tbody>
                  @foreach ($raw_materials as $item)
                    <tr>
                      <td>{{ $item->material_name }}</td>
                      <td>{{ $item->material_type }}</td>
                      <td>{{ $item->material_quantity }} ({{ $item->quantity_unit }})</td>
                      <td>{{ date('d M, Y - h:i a', strtotime($item->created_at)) }}</td>
                      <td>
                        <div class="dropdown">
                          <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                          </button>
                          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            {{-- @can('material-list')
                              <a class="dropdown-item" href="{{ route('raw-materials.show', $item->id) }}"><i
                                  class="fa fa-eye text-primary"></i> View</a>
                            @endcan --}}
                            {{-- @can('material-edit')
                              <a class="dropdown-item" href="{{ route('raw-materials.edit', $item->id) }}"><i
                                  class="fa fa-pen text-warning"></i> Edit</a>
                            @endcan --}}
                            @can('material-delete')
                              <form action="{{ route('raw-materials.destroy', $item->id) }}"
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

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 70vw">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Raw Material Add Form</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="raw_insert_form" action="{{ route('raw-materials.store') }}" method="post">
          <div class="modal-body">
            @csrf

            {{-- This is for header --}}
            <div class="row">
              <div class="col-3">
                <label><strong>Material Name</strong></label>
              </div>
              <div class="col-4">
                <label><strong>Material Type</strong></label>
              </div>
              <div class="col-2">
                <label><strong>Material Unit</strong></label>
              </div>
              <div class="col-3">
                <label><strong>Request Handler Role</strong></label>
              </div>
            </div>

            {{-- this is form body --}}
            <div class="form-body">
              <div class="row">
                <div class="col-3">
                  <input type="text" name="material_name[]" class="form-control" placeholder="Bottle, Label, Oil etc."
                    required>

                </div>
                <div class="col-4">
                  <input type="text" name="material_type[]" class="form-control"
                    placeholder="1ltr, 5ltr, soyabean, palm etc" required>

                </div>
                <div class="col-2">
                  <select name="quantity_unit[]" class="form-control" required>
                    <option value="" selected disabled>Select One</option>
                    <option value="piece">piece</option>
                    <option value="kg">kg</option>
                  </select>
                </div>
                <div class="col-3" id="req_handler_role_field">
                  <select name="req_handler_role[]" class="form-control" required>
                    <option value="" selected disabled>Select One</option>
                    @foreach ($roles as $item)
                      <option value="{{ $item }}">{{ $item }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>

            {{-- Add More Button --}}
            <div class="d-flex justify-content-end my-3">
              <button class="btn btn-primary add-more-btn"><i class="fa fa-plus mr-2"></i> Add More Field</button>
            </div>

            {{-- errors area --}}
            <ul id="errors" class="text-danger my-2"></ul>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <input type="reset" class="btn btn-danger mr-3" value="Reset Form">
            <input id="submit-btn" type="button" class="btn btn-success" value="Add Material">
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

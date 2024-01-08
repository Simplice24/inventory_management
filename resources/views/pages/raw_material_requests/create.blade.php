@extends('layouts.admin')

@section('title', 'Request Raw Material')

@push('styles')
@endpush

@push('scripts')
  <script>
    $(document).ready(function() {
      // function for get type list as per item names
      function get_types() {
        var val = $('#_name').val();

        // csrf bind
        var token = $("meta[name='csrf-token']").attr("content");

        $.post("/raw-material-requests/get-item-types", {
            material_name: val,
            _token: token
          },
          function(data, status) {
            if (data.success) {
              // console.log(data.unit)
              // clear type list
              $('#_type').html('');
              $('.qty_unit').html('');

              let item_types = data.types;

              // generate content
              var content = '<option value="" selected disabled>Select One</option>';
              item_types.forEach(element => {
                content += '<option value="' + element
                  .material_type + '">' + element.material_type +
                  '</option>';
              });

              $('#_type').html(content);
              $('.qty_unit').text(data.unit);
            }
          });
      }

      // call function 
      get_types();

      $('#_name').on('change', function() {
        get_types();
      });
    });
  </script>
@endpush

@section('content')
  <div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Request Raw Material</h1>

    <div class="row justify-content-center">
      <div class="col-6">
        <div class="card shadow mb-4">
          <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h5 class="m-0 font-weight-bold text-primary">Raw Material Request Form</h5>
            @can('raw-req-list')
              <a href="{{ route('raw-material-requests.index') }}" class="btn btn-outline-warning">Back</a>
            @endcan
          </div>

          <form action="{{ route('raw-material-requests.store') }}" method="POST">
            @csrf
            <div class="card-body">

              <div class="form-group">
                <label for="_name"><strong>Select Item:</strong></label>
                <select name="material_name" id="_name"
                  class="form-control @error('material_name') is-invalid @enderror">
                  <option value="" selected disabled>Select One</option>

                  @foreach ($item_list as $item)
                    <option value="{{ $item->material_name }}"
                      {{ old('material_name') == $item->material_name ? 'selected' : '' }}>{{ $item->material_name }}
                    </option>
                  @endforeach
                </select>

                @error('material_name')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>

              <div class="form-group">
                <label for="_type"><strong>Select Type:</strong></label>
                <select name="material_type" id="_type"
                  class="form-control @error('material_type') is-invalid @enderror">
                  <option value="" selected disabled>Select One</option>
                </select>

                @error('material_type')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>

              <div class="form-group">
                <label for="_qty"><strong>Enter Quantity (<span class="qty_unit"></span>):</strong></label>
                <input type="number" id="_qty" name="material_quantity" value="{{ old('material_quantity') }}"
                  class="form-control @error('material_quantity') is-invalid @enderror" placeholder="Enter Quantity">

                @error('material_quantity')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>
            </div>
            <div class="card-footer d-flex justify-content-end">
              <input type="submit" value="SUBMIT" class="btn btn-success">
            </div>
          </form>

        </div>
      </div>

    </div>
  </div>
@endsection

@extends('layouts.admin')

@section('title', 'Create Production Material')

@push('styles')
@endpush

@push('scripts')
  {{-- <script>
    $(document).ready(function() {
      // function for get type list as per item names
      function get_types() {
        var val = $('#_name').val();

        // csrf bind
        var token = $("meta[name='csrf-token']").attr("content");

        $.post("/production-materials/get-item-types", {
            material_name: val,
            _token: token
          },
          function(data, status) {
            if (data.success) {
              console.log(data.unit)
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
  </script> --}}
@endpush

@section('content')
  <div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Production Material</h1>

    <div class="row justify-content-center">
      <div class="col-6">
        <div class="card shadow mb-4">
          <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h5 class="m-0 font-weight-bold text-primary">Production Material Creation Form</h5>
            @can('production-list')
              <a href="{{ route('production-materials.index') }}" class="btn btn-outline-warning">Back</a>
            @endcan
          </div>

          <form action="{{ route('production-materials.store') }}" method="POST">
            @csrf
            <div class="card-body">

              <div class="form-group">
                <label for="_raw_mat_id"><strong>Select Material:</strong></label>
                <select name="raw_material_id" id="_raw_mat_id"
                  class="form-control @error('raw_material_id') is-invalid @enderror">
                  <option value="" selected disabled>Select One</option>

                  @foreach ($raw_materials as $item)
                    <option value="{{ $item->id }}" {{ old('raw_material_id') == $item->id ? 'selected' : '' }}>
                      {{ ucwords($item->material_type) }} {{ ucwords($item->material_name) }}
                    </option>
                  @endforeach
                </select>

                @error('raw_material_id')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>

              <div class="form-group">
                <label for="_pac_size"><strong>Select Pac Size:</strong></label>
                <select name="pac_size" id="_pac_size" class="form-control @error('pac_size') is-invalid @enderror">
                  <option value="" selected disabled>Select One</option>
                  <option value="1">1 ltr</option>
                  <option value="2">2 ltr</option>
                  <option value="5">5 ltr</option>
                </select>

                @error('pac_size')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
              </div>

              <div class="form-group">
                <label for="_req_handler"><strong>Select Request Handler Role:</strong></label>
                <select name="req_handler_role" id="_req_handler"
                  class="form-control @error('req_handler_role') is-invalid @enderror">
                  <option value="" selected disabled>Select One</option>
                  @foreach ($roles as $item)
                    <option value="{{ $item }}" {{ old('req_handler_role') == $item ? 'selected' : '' }}>
                      {{ $item }}
                    </option>
                  @endforeach
                </select>

                @error('req_handler_role')
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

@extends('layouts.admin')

@section('title', 'Request Production Material')

@push('styles')
@endpush

@push('scripts')
  <script>
    $(document).ready(function() {
      // function for get type list as per item names
      function get_sizes() {
        var val = $('#_name').val();
        // csrf bind
        var token = $("meta[name='csrf-token']").attr("content");
        $.post("/production-material-requests/get-pac-sizes", {
            material_name: val,
            _token: token
          },
          function(data, status) {
            if (data.success) {
              // console.log(data.pac_sizes)

              // clear type list
              $('#_pac_size').html('');

              let pac_sizes = data.pac_sizes;

              // generate content
              var content = '<option value="" selected disabled>Select One</option>';
              pac_sizes.forEach(element => {
                content += '<option value="' + element
                  .pac_size + '">' + element.pac_size +
                  ' (ltr)</option>';
              });

              $('#_pac_size').html(content);
            }
          });
      }

      // call function 
      get_sizes();

      $('#_name').on('change', function() {
        get_sizes();
      });

      // form submission
      $('#submit_btn').click(function(e) {
        e.preventDefault();

        let myform = document.getElementById('production_req_form');
        let formData = new FormData(myform);

        // remove all css if previous exists
        $('#_name').removeClass('is-invalid');
        $('#_pac_size').removeClass('is-invalid');
        $('#_qty').removeClass('is-invalid');

        $('.errors').remove();

        $.ajax({
          url: "/production-material-requests",
          data: formData,
          cache: false,
          processData: false,
          contentType: false,
          type: 'POST',
          success: function(response) {
            // console.log(response)
            // clear type list

            if (response.success) {
              location.reload();
            } else {
              // console.log(response[0].items)
              // set quantity error
              if (response[0].quantity) {
                $('#_qty').addClass('is-invalid');
                $('#_qty').after('<span class="invalid-feedback errors" role="alert"><strong>' + response[0]
                  .quantity +
                  '</strong></span>');
              }

              // set material error
              if (response[0].items) {
                $('#_pac_size').addClass('is-invalid');
                $('#_pac_size').after('<span class="invalid-feedback errors" role="alert"><strong>' +
                  response[0].items +
                  '</strong></span>');
              }
            }
          }
        }).fail(function(jqXHR, textStatus, error) {
          // get errors list
          let errors = jQuery.parseJSON(jqXHR.responseText).errors;

          // convert object to array
          // let errorsArray = Object.keys(errors).map(function(key) {
          //   return errors[key];
          // });
          // console.log(errors);

          // add css to fields and add errors after fields
          if (errors.material_name) {
            $('#_name').addClass('is-invalid');
            $('#_name').after('<span class="invalid-feedback errors" role="alert"><strong>' + errors
              .material_name[0] +
              '</strong></span>');
          }
          if (errors.pac_size) {
            $('#_pac_size').addClass('is-invalid');
            $('#_pac_size').after('<span class="invalid-feedback errors" role="alert"><strong>' + errors
              .pac_size[
                0] +
              '</strong></span>');
          }
          if (errors.material_quantity) {
            $('#_qty').addClass('is-invalid');
            $('#_qty').after('<span class="invalid-feedback errors" role="alert"><strong>' + errors
              .material_quantity[0] +
              '</strong></span>');
          }
        });

      });
    });
  </script>
@endpush

@section('content')
  <div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Request Production Material</h1>

    <div class="row justify-content-center">
      <div class="col-6">
        <div class="card shadow mb-4">
          <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h5 class="m-0 font-weight-bold text-primary">Production Material Request Form</h5>
            @can('production-req-list')
              <a href="{{ route('production-material-requests.index') }}" class="btn btn-outline-warning">Back</a>
            @endcan
          </div>

          <form id="production_req_form" action="{{ route('production-material-requests.store') }}" method="POST">
            @csrf
            <div class="card-body">

              <div class="form-group">
                <label for="_name"><strong>Select Item:</strong></label>
                <select name="material_name" id="_name" class="form-control">
                  <option value="" selected disabled>Select One</option>

                  @foreach ($production_materials as $item)
                    <option value="{{ $item->material_name }}">{{ $item->material_name }}
                    </option>
                  @endforeach
                </select>
              </div>

              <div class="form-group">
                <label for="_pac_size"><strong>Select Pac Size:</strong></label>
                <select name="pac_size" id="_pac_size" class="form-control">
                  <option value="" selected disabled>Select One</option>
                </select>
              </div>

              <div class="form-group">
                <label for="_qty"><strong>Enter Quantity (piece/pieces):</strong></label>
                <input type="number" id="_qty" name="material_quantity" class="form-control"
                  placeholder="Enter Quantity">
              </div>
            </div>

            <div class="card-footer d-flex justify-content-end">
              <input type="submit" id="submit_btn" value="SUBMIT" class="btn btn-success">
            </div>
          </form>

        </div>
      </div>

    </div>
  </div>
@endsection

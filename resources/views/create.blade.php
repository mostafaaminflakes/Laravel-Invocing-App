@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div>NEW INVOICE</div>
                    <!-- <div class="fw-light fs-6 mt-1">Invoice Number: OSX-001</div> -->
                </div>
                <div class="card-body">
                    <!-- <form method="post" action="{{ route('store') }}" name="add_invoice_items" id="add_invoice_items"> -->
                    <form name="add_invoice_items" id="add_invoice_items">
                        @csrf
                        @if($errors->any())
                        <div class="alert alert-danger fs-6">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <div class="fw-bold border-bottom mb-3">Client Information</div>
                        <div class="mb-3 form-group">
                            <label for="client_name" class="form-label">Name</label>
                            <input type="text" name="client_name" id="client_name" class="form-control{{ $errors->has('client_name') ? ' is-invalid' : '' }}" value="{{ (old('client_name') ? old('client_name') : '' ) }}" placeholder="Client name">
                            <div class="text-danger fs-6"></div>
                        </div>
                        <div class="mb-3 form-group{{ $errors->has('client_address') ? ' danger' : '' }}">
                            <label for="client_address" class="form-label">Address</label>
                            <input type="text" name="client_address" id="client_address" class="form-control{{ $errors->has('client_address') ? ' is-invalid' : '' }}" value="{{ (old('client_address') ? old('client_address') : '' ) }}" placeholder="Client address">
                            <div class="text-danger fs-6" id="client_address_msg"></div>

                        </div>
                        <div class="mb-3 form-group{{ $errors->has('client_vat_number') ? ' has-error' : '' }}">
                            <label for="client_vat_number" class="form-label">VAT Number</label>
                            <input type="text" name="client_vat_number" id="client_vat_number" class="form-control{{ $errors->has('client_vat_number') ? ' is-invalid' : '' }}" value="{{ (old('client_vat_number') ? old('client_vat_number') : '' ) }}" placeholder="Client VAT number">
                            <div class="text-danger fs-6"></div>

                        </div>

                        <div class="fw-bold border-bottom mt-5 mb-3">Invoice Details</div>
                        <div class="alert alert-danger show-error-message" style="display:none">
                            <ul></ul>
                        </div>
                        <div class="alert alert-success show-success-message" style="display:none">
                            <ul></ul>
                        </div>
                        @error('client_vat_number')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <table class="table table-bordered" id="dynamicTable">
                            <tr class="bg-light text-dark h6">
                                <th>Serice Name</th>
                                <th>Unit Price</th>
                                <th>Quantity</th>
                                <th></th>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" name="invoice_items[0][service_name]" placeholder="Service name" class="form-control{{ $errors->has('invoice_items.0.service_name') ? ' is-invalid' : '' }}" />
                                    <div class="text-danger fs-6"></div>
                                </td>
                                <td>
                                    <input type="text" name="invoice_items[0][unit_price]" placeholder="Unit price" class="form-control{{ $errors->has('invoice_items.0.unit_price') ? ' is-invalid' : '' }}" />
                                    <div class="text-danger fs-6"></div>
                                </td>
                                <td>
                                    <input type="text" name="invoice_items[0][quantity]" placeholder="Quantity" class="form-control{{ $errors->has('invoice_items.0.quantity') ? ' is-invalid' : '' }}" />
                                    <div class="text-danger fs-6"></div>
                                </td>
                                <td><button type="button" name="add" id="add" class="btn btn-success">Add More</button></td>
                            </tr>
                        </table>
                        <button type="submit" class="btn btn-primary" id="submit">Create Invoice</button>
                        <div id="spinner"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        var i = 0;
        $("#add").click(function() {
            ++i;
            $("#dynamicTable").append('<tr><td><input type="text" name="invoice_items[' + i + '][service_name]" placeholder="Service name" class="form-control" /><div class="text-danger fs-6"></div></td><td><input type="text" name="invoice_items[' + i + '][unit_price]" placeholder="Unit price" class="form-control" /><div class="text-danger fs-6"></div></td><td><input type="text" name="invoice_items[' + i + '][quantity]" placeholder="Quantity" class="form-control" /><div class="text-danger fs-6"></div></td><td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>');
        });

        $(document).on('click', '.remove-tr', function() {
            $(this).parents('tr').remove();
        });

        $('#submit').click(function(e) {
            e.preventDefault();
            $.ajax({
                    method: "POST",
                    url: "{{ route('store') }}",
                    data: $('#add_invoice_items').serialize(),
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: "json",
                    beforeSend: function() {
                        $("#submit").prop('disabled', true);
                        $('#spinner').addClass('spinner');
                    }
                })
                .done(function(data) {
                    // Laravel FormRequest using AJAX returns 422 status code failed validation.
                    // That's why we handle validation in the failed method.
                })
                .fail(function(data) {
                    $("#submit").prop('disabled', false);
                    $('#spinner').removeClass('spinner');
                    $.each(data.responseJSON.errors, function(key, value) {
                        if (~key.indexOf(".")) {
                            newkey = key.split('.');
                            key = newkey[0] + '[' + newkey[1] + '][' + newkey[2] + ']';
                        }
                        var input = '#add_invoice_items input[name="' + key + '"]';
                        $(input + '+div').text(value);
                        $(input).addClass('is-invalid');
                    });
                });
        });
    });
</script>
@endsection
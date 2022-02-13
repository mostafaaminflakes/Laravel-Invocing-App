@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div><strong>{{ __('NEW INVOICE') }}</strong></div>
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
                        <div class="fw-bold border-bottom mb-3">{{ __('Client Information') }}</div>
                        <div class="row">
                            <div class="col mb-3">
                                <div>
                                    <label for="client_name" class="form-label">{{ __('Name') }} <span class="fw-light fs-6 text-danger">*</span></label>
                                    <input type="text" name="client_name" id="client_name" class="form-control" value="{{ (old('client_name') ? old('client_name') : '' ) }}" placeholder="{{ __('Name') }}">
                                </div>
                                <div class="text-danger fs-6 err-msg"></div>
                            </div>
                            <div class="col-sm-4 mb-3">
                                <div>
                                    <label for="client_vat_number" class="form-label">{{ __('VAT Number') }}</label>
                                    <input type="text" name="client_vat_number" id="client_vat_number" class="form-control" value="{{ (old('client_vat_number') ? old('client_vat_number') : '' ) }}" placeholder="{{ __('VAT number') }}">
                                </div>
                                <div class="text-danger fs-6 err-msg"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <div>
                                    <label for="project_name" class="form-label">{{ __('Project Name') }} <span class=" fw-light fs-6 text-danger">*</span></label>
                                    <input type="text" name="project_name" id="project_name" class="form-control" value="{{ (old('project_name') ? old('project_name') : '' ) }}" placeholder="{{ __('Project Name') }}">
                                </div>
                                <div class="text-danger fs-6 err-msg"></div>
                            </div>
                            <div class="col-sm-4 mb-3">
                                <div>
                                    <label for="project_number" class="form-label">{{ __('Project Number') }}</label>
                                    <input type="text" name="project_number" id="project_number" class="form-control" value="{{ (old('project_number') ? old('project_number') : '' ) }}" placeholder="{{ __('Project Number') }}">
                                </div>
                                <div class="text-danger fs-6 err-msg"></div>
                            </div>
                        </div>
                        <div>
                            <label for="notes" class="form-label">{{ __('Notes') }}</label>
                            <input type=" text" name="notes" id="notes" class="form-control" value="{{ (old('notes') ? old('notes') : '' ) }}" placeholder="{{ __('Notes') }}">
                            <div class="text-danger fs-6 err-msg"></div>
                        </div>

                        <div class="fw-bold border-bottom mt-3 mb-3">{{ __('Invoice Details') }}</div>
                        <table class=" table table-bordered" id="dynamicTable">
                            <tr class="bg-light text-dark h6">
                                <th>{{ __('Service Name') }} <span class="fw-light fs-6 text-danger">*</span></th>
                                <th>{{ __('Unit') }} <span class="fw-light fs-6 text-danger">*</span></th>
                                <th>{{ __('Completion') }} <span class="fw-light fs-6 text-danger">*</span></th>
                                <th>{{ __('Unit Price') }} <span class="fw-light fs-6 text-danger">*</span></th>
                                <th>{{ __('Quantity') }} <span class="fw-light fs-6 text-danger">*</span></th>
                                <th></th>
                            </tr>
                            <tr>
                                <td>
                                    <div class="input-group">
                                        <input type="text" name="invoice_items[0][service_name]" placeholder="{{ __('Service name') }}" class="form-control{{ $errors->has('invoice_items.0.service_name') ? ' is-invalid' : '' }}" />
                                    </div>
                                    <div class="text-danger fs-6 err-msg"></div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <input type="text" name="invoice_items[0][unit]" placeholder="{{ __('Unit') }}" class="form-control{{ $errors->has('invoice_items.0.unit') ? ' is-invalid' : '' }}" />
                                    </div>
                                    <div class="text-danger fs-6 err-msg"></div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <input type="text" name="invoice_items[0][completion]" placeholder="{{ __('Completion rate') }}" class="form-control{{ $errors->has('invoice_items.0.completion') ? ' is-invalid' : '' }}" />
                                        <div><span class="input-group-text">%</span></div>
                                    </div>
                                    <div class="text-danger fs-6 err-msg d-sm-block"></div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <input type="text" name="invoice_items[0][unit_price]" placeholder="{{ __('Unit price') }}" class="form-control{{ $errors->has('invoice_items.0.unit_price') ? ' is-invalid' : '' }}" />
                                        <div><span class="input-group-text">{{ __('SAR') }}</span></div>
                                    </div>
                                    <div class="text-danger fs-6 err-msg"></div>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <input type="text" name="invoice_items[0][quantity]" placeholder="{{ __('Quantity') }}" class="form-control{{ $errors->has('invoice_items.0.quantity') ? ' is-invalid' : '' }}" />
                                    </div>
                                    <div class="text-danger fs-6 err-msg"></div>
                                </td>
                                <td><button type="button" name="add" id="add" class="btn btn-success">{{ __('Add') }}</button></td>
                            </tr>
                        </table>
                        <button type="submit" class="btn btn-primary" id="submit">{{ __('Create Invoice') }}</button>
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
            $("#dynamicTable").append('<tr><td><div class="input-group"><input type="text" name="invoice_items[' + i + '][service_name]" placeholder="{{ __("Service name") }}" class="form-control" /></div><div class="text-danger fs-6 err-msg"></div></td><td><div class="input-group"><input type="text" name="invoice_items[' + i + '][unit]" placeholder="{{ __("Unit") }}" class="form-control" /></div><div class="text-danger fs-6 err-msg"></div></td><td><div class="input-group"><input type="text" name="invoice_items[' + i + '][completion]" placeholder="{{ __("Completion rate") }}" class="form-control" /><div><span class="input-group-text">%</span></div></div><div class="text-danger fs-6 err-msg"></div></td><td><div class="input-group"><input type="text" name="invoice_items[' + i + '][unit_price]" placeholder="{{ __("Unit price") }}" class="form-control" /><div><span class="input-group-text">{{ __("SAR") }}</span></div></div><div class="text-danger fs-6 err-msg"></div></td><td><div class="input-group"><input type="text" name="invoice_items[' + i + '][quantity]" placeholder="{{ __("Quantity") }}" class="form-control" /></div><div class="text-danger fs-6 err-msg"></div></td><td><button type="button" class="btn btn-danger remove-tr">{{ __("Remove") }}</button></td></tr>');
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
                .done(function(data, textStatus, xhr) {
                    // Laravel FormRequest using AJAX returns 422 status code failed validation.
                    // That's why we handle validation in the failed method.
                    $("#submit").prop('disabled', false);
                    $('#spinner').removeClass('spinner');
                    if (xhr.status == 200 && data.success == true) {
                        var url = '{{ route("details", ":id") }}';
                        url = url.replace(':id', data.invoice);
                        window.location.href = url;
                    }
                })
                .fail(function(data) {
                    $("#submit").prop('disabled', false);
                    $('#spinner').removeClass('spinner');
                    $('form#add_invoice_items input[type=text]').each(function() {
                        //$(this).siblings('.err-msg').text('');
                        $(this).parent().next('div.err-msg').text('');
                        $(this).removeClass('is-invalid');
                    });

                    if (data.status == 422) { // When status code is 422, it's a validation issue
                        $.each(data.responseJSON.errors, function(key, value) {
                            if (~key.indexOf(".")) {
                                newkey = key.split('.');
                                key = newkey[0] + '[' + newkey[1] + '][' + newkey[2] + ']';
                            }
                            var input = '#add_invoice_items input[name="' + key + '"]';
                            // $(input + '+div').text(value);
                            $(input).parent().next('div.err-msg').text(value);
                            $(input).addClass('is-invalid');
                        });
                    }
                });

        });
    });
</script>
@endsection
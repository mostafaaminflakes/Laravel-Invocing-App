@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div><strong>{{ __('INVOICE DETAILS') }}</strong></div>
                    <!-- <div class="fw-light fs-6 mt-1">Invoice Number: OSX-001</div> -->
                    <div class="fw-light fs-6 mt-1"><button type="submit" class="btn btn-success btn-lg" id="submit">{{ __('Export') }}</button></div>
                </div>
                <div class="card-body">
                    <!-- <form method="post" action="{{ route('store') }}" name="add_invoice_items" id="add_invoice_items"> -->
                    <form name="add_invoice_items" id="add_invoice_items">
                        @csrf
                        <div class="col-md-12 row mb-3">
                            <div class="col-4">
                                <img src="{{ asset('/images/logo_emara.jpg') }}" alt="">
                            </div>
                            <div class="col-4 justify-content-center align-items-center d-flex">
                                <div class="h1">
                                    <div>{{ __('Simplified Tax Invoice') }}</div>
                                    Simplified Tax Invoice
                                </div>
                            </div>
                            <div class="col-4 text-start">
                                <img src="{{ asset('/images/logo_emara.jpg') }}" alt="">
                            </div>
                        </div>
                        <div class="col-md-12 row mb-3">
                            <div>
                                <div class="float-end ps-1">{{ __('Invoice Number') }} - Invoice Number:</div>
                                <div>EFC00{{ $invoice->invoice_number }}</div>
                            </div>
                            <div>
                                <div class="float-end ps-1">{{ __('Date') }} - Date:</div>
                                <div>{{ $invoice->created_at }}</div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-6">
                                    <div class="fw-bold border-bottom col-11">{{ __('Seller Information') }} - Seller Information</div>
                                    <div class="col-11">
                                        <table class="table">
                                            <tr>
                                                <td class="col-4">{{ __('Name') }}</td>
                                                <td class="pe-4">{{ $invoice->client_name }}</td>
                                                <td class="text-start col-4">Name</td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('VAT Number') }}</td>
                                                <td class="pe-4">{{ $invoice->client_vat_number }}</td>
                                                <td class="text-start">VAT Number</td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('CR Number') }}</td>
                                                <td class="pe-4">{{ $invoice->project_number }}</td>
                                                <td class="text-start">CR Number</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="fw-bold border-bottom col-12">{{ __('Client Information') }} - Client Information</div>
                                    <div class="col-12">
                                        <table class="table">
                                            <tr>
                                                <td class="col-4">{{ __('Name') }}</td>
                                                <td class="pe-4">{{ $invoice->client_name }}</td>
                                                <td class="text-start col-4">Name</td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('VAT Number') }}</td>
                                                <td class="pe-4">{{ $invoice->client_vat_number }}</td>
                                                <td class="text-start">VAT Number</td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('Project Name') }}</td>
                                                <td class="pe-4">{{ $invoice->project_name }}</td>
                                                <td class="text-start">Project Name</td>
                                            </tr>
                                            <tr>
                                                <td>{{ __('Project Number') }}</td>
                                                <td class="pe-4">{{ $invoice->project_number }}</td>
                                                <td class="text-start">Project Number</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div>
                                    <label for="notes" class="form-label">{{ __('Notes') }}</label>
                                    {{ ! empty($invoice->notes) ? $invoice->notes : '--' }}
                                    <div class="text-danger fs-6 err-msg"></div>
                                </div>
                            </div>

                            <div class="fw-bold border-bottom mt-3 mb-3">{{ __('Invoice Details') }} - Invoice Details</div>
                            <table class="table table-bordered" id="dynamicTable">
                                <tr class="bg-light text-dark h6">
                                    <th class="col-4">
                                        <p class="m-0 pb-1">{{ __('Service Name') }}</p>
                                        <p class="m-0">Service Name</p>
                                    </th>
                                    <th class="col-1">
                                        <p class="m-0 pb-1">{{ __('Unit') }}
                                        <p class="m-0">Unit</p>
                                    </th>
                                    <th class="col-1">
                                        <p class="m-0 pb-1">{{ __('Completion') }}</p>
                                        <p class="m-0">Completion</p>
                                    </th>
                                    <th class="col-1">
                                        <p class="m-0 pb-1">{{ __('Unit Price') }}</p>
                                        <p class="m-0">Unit Price</p>
                                    </th>
                                    <th class="col-1">
                                        <p class="m-0 pb-1">{{ __('Quantity') }}</p>
                                        <p class="m-0">Quantity</p>
                                    </th>
                                    <th class="col-1">
                                        <p class="m-0 pb-1">{{ __('Net Amount') }}</p>
                                        <p class="m-0">Net Amount</p>
                                    </th>
                                </tr>
                                @php
                                $total_before_vat = 0;
                                @endphp
                                @foreach ($invoice_items as $invoice_item)
                                @php
                                $total_before_vat += $invoice_item->unit_price * $invoice_item->quantity;
                                @endphp
                                <tr>
                                    <td>{{ $invoice_item->service_name }}</td>
                                    <td>{{ $invoice_item->unit }}</td>
                                    <td>{{ $invoice_item->completion }}%</td>
                                    <td>{{ $invoice_item->unit_price }} {{ __('SAR') }}</td>
                                    <td>{{ $invoice_item->quantity }}</td>
                                    <td>{{ $invoice_item->unit_price * $invoice_item->quantity }} {{ __('SAR') }}</td>
                                </tr>
                                @endforeach
                            </table>
                            <table class="table table-borderless">
                                <tr>
                                    <td class="col-6">&nbsp;</td>
                                    <td class="text-start ps-4 fw-bold border-bottom col-2">
                                        <p class="m-0 pb-1">{{ __('Total Amount Before VAT') }}</p>
                                        <p class="m-0">Total Amount Before VAT</p>
                                    </td>
                                    <td class="col-1 border-bottom">{{ round($total_before_vat) }} {{ __('SAR') }}</td>
                                </tr>
                                <tr>
                                    <td class="col-6">&nbsp;</td>
                                    <td class="text-start ps-4 fw-bold border-bottom">
                                        <p class="m-0 pb-1">{{ __('VAT') }} 15%</p>
                                        <p class="m-0">VAT 15%</p>
                                    </td>
                                    <td class="border-bottom">{{ round($total_before_vat * 0.15) }} {{ __('SAR') }}</td>
                                </tr>
                                <tr>
                                    <td class="col-6">&nbsp;</td>
                                    <td class="text-start ps-4 fw-bold border-bottom">
                                        <p class="m-0 pb-1">{{ __('Total Amount After VAT') }}</p>
                                        <p class="m-0">Total Amount After VAT</p>
                                    </td>
                                    <td class="border-bottom">{{ round($total_before_vat * 1.15) }} {{ __('SAR') }}</td>
                                </tr>
                            </table>
                            <!-- <div class="text-center mt-5">
                                <button type="submit" class="btn btn-success btn-lg" id="submit">{{ __('Export') }}</button>
                                <div id="spinner"></div>
                            </div> -->
                        </div>
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
            $("#dynamicTable").append('<tr><td><div class="input-group"><input type="text" name="invoice_items[' + i + '][service_name]" placeholder="{{ __("Service name") }}" class="form-control" /></div><div class="text-danger fs-6 err-msg"></div></td><td><div class="input-group"><input type="text" name="invoice_items[' + i + '][unit]" placeholder="{{ __("Unit") }}" class="form-control" /></div><div class="text-danger fs-6 err-msg"></div></td><td><div class="input-group"><input type="text" name="invoice_items[' + i + '][completion]" placeholder="{{ __("Completion rate") }}" class="form-control" /><div><div class="input-group-text">%</div></div></div><div class="text-danger fs-6 err-msg"></div></td><td><div class="input-group"><input type="text" name="invoice_items[' + i + '][unit_price]" placeholder="{{ __("Unit price") }}" class="form-control" /><div><div class="input-group-text">{{ __("SAR") }}</div></div></div><div class="text-danger fs-6 err-msg"></div></td><td><div class="input-group"><input type="text" name="invoice_items[' + i + '][quantity]" placeholder="{{ __("Quantity") }}" class="form-control" /></div><div class="text-danger fs-6 err-msg"></div></td><td><button type="button" class="btn btn-danger remove-tr">{{ __("Remove") }}</button></td></tr>');
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
                        window.location.href = "{{ route('home') }}";
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
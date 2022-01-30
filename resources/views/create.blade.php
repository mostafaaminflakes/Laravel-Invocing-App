@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div>NEW INVOICE</div>
                    <div class="fw-light fs-6 mt-1">Invoice Number: OSX-001</div>
                </div>
                <div class="card-body">
                    <form method="post" action="">
                        @csrf
                        @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <div class="fw-bold border-bottom mb-3">Buyer Information</div>
                        <div class="mb-3 form-group{{ $errors->has('recipient') ? ' has-error' : '' }}">
                            <label for="recipient" class="form-label">Name</label>
                            <input type="text" name="recipient" id="recipient" class="form-control" value="{{ (old('recipient') ? old('recipient') : '' ) }}" placeholder="Buyer name">
                            @if ($errors->has('recipient'))
                            <div class="help-block danger">
                                {{ $errors->first('recipient') }}
                            </div>
                            @endif
                        </div>
                        <div class="mb-3 form-group{{ $errors->has('recipient') ? ' has-error' : '' }}">
                            <label for="recipient" class="form-label">Address</label>
                            <input type="text" name="recipient" id="recipient" class="form-control" value="{{ (old('recipient') ? old('recipient') : '' ) }}" placeholder="Buyer address">
                            @if ($errors->has('recipient'))
                            <div class="help-block danger">
                                {{ $errors->first('recipient') }}
                            </div>
                            @endif
                        </div>
                        <div class="mb-3 form-group{{ $errors->has('recipient') ? ' has-error' : '' }}">
                            <label for="recipient" class="form-label">VAT Number</label>
                            <input type="text" name="recipient" id="recipient" class="form-control" value="{{ (old('recipient') ? old('recipient') : '' ) }}" placeholder="Buyer VAT number">
                            @if ($errors->has('recipient'))
                            <div class="help-block danger">
                                {{ $errors->first('recipient') }}
                            </div>
                            @endif
                        </div>

                        <div class="fw-bold border-bottom mt-5 mb-3">Invoice Details</div>
                        <table class="table table-bordered" id="dynamicTable">
                            <tr class="bg-light text-dark h6">
                                <th>Serice Name</th>
                                <th>Unit Price</th>
                                <th>Quantity</th>
                                <th></th>
                            </tr>
                            <tr>
                                <td><input type="text" name="addmore[0][name]" placeholder="Service name" class="form-control" /></td>
                                <td><input type="text" name="addmore[0][qty]" placeholder="Unit price" class="form-control" /></td>
                                <td><input type="text" name="addmore[0][price]" placeholder="Quantity" class="form-control" /></td>
                                <td><button type="button" name="add" id="add" class="btn btn-success">Add More</button></td>
                            </tr>
                        </table>


                        <!-- <div class="form-group">
                            <div class="input-group">
                                <div class="mb-3">
                                    <label class="form-label" for="seller_name">Invoice Number</label>
                                    <input class="form-control form-control" type="text" id="seller_name" name="seller_name" value="{{ old('seller_name') }}">
                                    <p class="form-text">Example: My Company</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="vat_number">VAT Number</label>
                                    <input class="form-control form-control" type="text" id="vat_number" name="vat_number" value="{{ old('vat_number') }}">
                                    <p class="form-text"><small>Example: 310000000000000</small></p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="invoice_date">Date and Time</label>
                                    <input class="form-control form-control" type="datetime" id="invoice_date" name="invoice_date" value="{{ old('invoice_date') }}">
                                    <p class="form-text"><small>Example: 2022-12-15 14:41:15</small></p>
                                </div>
                            </div>
                        </div> -->
                        <h5 class="card-title mb-3 mt-4">Options</h5>
                        <div class="ms-4 mb-3">
                            <div class="mb-3">
                                <input class="form-check-input" type="checkbox" id="qr_logo" name="qr_logo" {{ old('qr_logo') == 'on' ? 'checked' : '' }}>
                                <label class="form-check-label" for="qr_logo">Add an image in the center of the QR Code</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="qr_options" id="option1" value="download" checked>
                                <label class="form-check-label" for="option1">
                                    Download QR Code image
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="qr_options" id="option2" value="store">
                                <label class="form-check-label" for="option2">
                                    Save QR Code image to server
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="qr_options" id="option3" value="pdf">
                                <label class="form-check-label" for="option3">
                                    Generate PDF with QR Code image
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Create Invoice</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var i = 0;
    $("#add").click(function() {
        ++i;
        $("#dynamicTable").append('<tr><td><input type="text" name="addmore[' + i + '][name]" placeholder="Service name" class="form-control" /></td><td><input type="text" name="addmore[' + i + '][qty]" placeholder="Unit price" class="form-control" /></td><td><input type="text" name="addmore[' + i + '][price]" placeholder="Quantity" class="form-control" /></td><td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>');
    });

    $(document).on('click', '.remove-tr', function() {
        $(this).parents('tr').remove();
    });
</script>
@endsection
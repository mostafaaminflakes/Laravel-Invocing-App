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
                                <td><input type="text" name="invoice_items[0][unit_price]" placeholder="Unit price" class="form-control{{ $errors->has('invoice_items.0.unit_price') ? ' is-invalid' : '' }}" />
                                    @if ($errors->has('invoice_items.0.unit_price'))
                                    <div class="text-danger fs-6">
                                        {{ $errors->first('invoice_items.0.unit_price') }}
                                    </div>
                                    @endif
                                </td>
                                <td><input type="text" name="invoice_items[0][quantity]" placeholder="Quantity" class="form-control{{ $errors->has('invoice_items.0.quantity') ? ' is-invalid' : '' }}" />
                                    @if ($errors->has('invoice_items.0.quantity'))
                                    <div class="text-danger fs-6">
                                        {{ $errors->first('invoice_items.0.quantity') }}
                                    </div>
                                    @endif
                                </td>
                                <td><button type="button" name="add" id="add" class="btn btn-success">Add More</button></td>
                            </tr>
                        </table>
                        <button type="submit" class="btn btn-primary" id="submit">Create Invoice</button>
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
            $("#dynamicTable").append('<tr><td><input type="text" name="invoice_items[' + i + '][service_name]" placeholder="Service name" class="form-control" /></td><td><input type="text" name="invoice_items[' + i + '][unit_price]" placeholder="Unit price" class="form-control" /></td><td><input type="text" name="invoice_items[' + i + '][quantity]" placeholder="Quantity" class="form-control" /></td><td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>');
        });

        $(document).on('click', '.remove-tr', function() {
            $(this).parents('tr').remove();
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                //'Content-Type': 'application/x-www-form-urlencoded',
                //'Content-Type': 'application/json'
            }
        });

        $('#submit').click(function(e) {
            e.preventDefault();
            $.ajax({
                    method: "POST", //$(this).attr('method'),
                    url: "{{ route('store') }}", //$(this).attr('action'),
                    data: $('#add_invoice_items').serialize(), //$(this).serialize(),
                    dataType: "json"
                })
                .done(function(data) {
                    $('.alert-success').removeClass('hidden');
                    $('#myModal').modal('hide');
                })
                .fail(function(data) {
                    //alert('Good Fail');
                    console.log(data.responseJSON);
                    $.each(data.responseJSON.errors, function(key, value) {
                        var input = '#add_invoice_items input[name=' + key + ']';
                        $(input + '+div').text(value);
                        console.log(input);
                        //$(input).parent().addClass('is-invalud');
                        $(input).addClass(' is-invalid');
                    });
                });



            // $.ajax({
            //     url: "{{ route('store') }}",
            //     method: "POST",
            //     data: $('#add_invoice_items').serialize(),
            //     // contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
            //     headers: {
            //         Accept: "application/json",
            //         // "Content-Type": "text/plain; charset=utf-8"
            //     },
            //     dataType: 'json',
            //     success: function(data) {
            //         console.log(data);
            //         if (data.errors) {
            //             //alert('hi');
            //             display_error_messages(data.errors);
            //             $('#client_address_msg').html(data.errors.client_address);
            //         } else {
            //             i = 1;
            //             // $('.dynamic-added').remove();
            //             $('#add_invoice_items')[0].reset();
            //             $(".show-success-message").find("ul").html('');
            //             $(".show-success-message").css('display', 'block');
            //             $(".show-error-message").css('display', 'none');
            //             $(".show-success-message").find("ul").append('<li>Todos Has Been Successfully Inserted.</li>');
            //         }
            //     },
            //     statusCode: {
            //         500: function() {
            //             // Server error
            //         },
            //         422: function(data) {
            //             $.each(data.responseJSON, function(key, value) {
            //                 // Set errors on inputs
            //                 alert('Good to go');
            //             });
            //         }
            //     },
            //     error: function(data) {
            //         alert('fail');
            //         if (data.status === 422) {
            //             var errors = $.parseJSON(data.responseText);
            //             $.each(errors, function(key, value) {
            //                 // console.log(key+ " " +value);
            //                 $(".show-success-message").css('display', 'block');
            //                 //$('#response').addClass("alert alert-danger");

            //                 if ($.isPlainObject(value)) {
            //                     $.each(value, function(key, value) {
            //                         console.log(key + " " + value);
            //                         // $('#response').show().append(value + "<br/>");
            //                         // $(".show-success-message").find("ul").append(value);
            //                     });
            //                 } else {
            //                     console.log(key + " " + value);
            //                     // $(".show-success-message").find("ul").append(value); //this is my div with messages
            //                 }
            //             });
            //         }
            //     }
            // });
        });

        // function display_error_messages(msg) {
        //     $(".show-error-message").find("ul").html('');
        //     $(".show-error-message").css('display', 'block');
        //     $(".show-success-message").css('display', 'none');
        //     $.each(msg, function(key, value) {
        //         $(".show-error-message").find("ul").append('<li>' + value + '</li>');
        //     });
        // }
    });

    // document
    //     .querySelector("form")
    //     .addEventListener("submit", handleSubmit);

    // const handleSubmit = (e) => {
    //     e.preventDefault();
    //     let myForm = document.getElementById("pizzaOrder");
    //     let formData = new FormData(myForm);
    //     fetch("/", {
    //             method: "POST",
    //             headers: {
    //                 "Content-Type": "application/x-www-form-urlencoded"
    //             },
    //             body: new URLSearchParams(formData).toString(),
    //         })
    //         .then(() => console.log("Form successfully submitted"))
    //         .catch((error) => alert(error));
    // };
</script>
@endsection
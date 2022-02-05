@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div><strong>{{ __('INVOICE DETAILS') }}</strong></div>
            <div class="fw-light fs-6 mt-1"><a href="{{ route('download-invoice', 'EFC00'.$invoice->invoice_number) }}" class="btn btn-success btn-lg">{{ __('Export') }}</a></div>
        </div>
        <div class="card-body">
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
                    <div class="float-end ps-1 fw-bold">{{ __('Invoice Number') }} - Invoice Number:</div>
                    <div>EFC00{{ $invoice->invoice_number }}</div>
                </div>
                <div>
                    <div class="float-end ps-1 fw-bold">{{ __('Date') }} - Date:</div>
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

                <!-- <div class="row">
                    <div>
                        <label for="notes" class="form-label">{{ __('Notes') }}</label>
                        {{ ! empty($invoice->notes) ? $invoice->notes : '--' }}
                        <div class="text-danger fs-6 err-msg"></div>
                    </div>
                </div> -->

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
                    @foreach ($invoice_items as $invoice_item)
                    <tr>
                        <td>{{ $invoice_item->service_name }}</td>
                        <td>{{ $invoice_item->unit }}</td>
                        <td>{{ $invoice_item->completion }}%</td>
                        <td>{{ $invoice_item->unit_price }} {{ __('SAR') }}</td>
                        <td>{{ $invoice_item->quantity }}</td>
                        <td>{{ $invoice_item->net_amount }} {{ __('SAR') }}</td>
                    </tr>
                    @endforeach
                </table>
                <table class="table table-borderless">
                    <tr>
                        <td class="col-6" rowspan="3">
                            <div>
                                <p class="fw-bold">{{ __('Notes') }}</p>
                                <p>{{ ! empty($invoice->notes) ? $invoice->notes : '--' }}</p>
                            </div>
                        </td>
                        <td class="text-start ps-4 fw-bold border-bottom col-2">
                            <p class="m-0 pb-1">{{ __('Total Amount Before VAT') }}</p>
                            <p class="m-0">Total Amount Before VAT</p>
                        </td>
                        <td class="col-1 border-bottom">{{ $invoice->total_amount_before_vat }} {{ __('SAR') }}</td>
                    </tr>
                    <tr>
                        <td class="text-start ps-4 fw-bold border-bottom">
                            <p class="m-0 pb-1">{{ __('VAT') }} 15%</p>
                            <p class="m-0">VAT 15%</p>
                        </td>
                        <td class="border-bottom">{{ $invoice->vat }} {{ __('SAR') }}</td>
                    </tr>
                    <tr>
                        <td class="text-start ps-4 fw-bold border-bottom">
                            <p class="m-0 pb-1">{{ __('Total Amount After VAT') }}</p>
                            <p class="m-0">Total Amount After VAT</p>
                        </td>
                        <td class="border-bottom">{{ $invoice->total_amount_after_vat }} {{ __('SAR') }}</td>
                    </tr>
                </table>
                <div class="text-center mt-5 border-top">
                    <div class="mt-3 h6">مؤسسة العمارة والفن للمقاولات</div>
                    <div class="h6">بنك البلاد - آيبان: SA4810000000484424000107</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
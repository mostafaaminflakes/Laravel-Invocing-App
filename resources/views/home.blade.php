@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="">
                <div class=" d-flex justify-content-between">
                    <div>{{ __('NEW INVOICE') }}</div>
                    <div class="fw-light fs-6 mt-1">Total invoices: {{ $invoices_mini->total() }}</div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <!-- <p><a href="{{ route('download-invoice') }}">Download Invoice</a></p> -->
                    <table class="table table-bordered" id="dynamicTable">
                        <tr class="bg-light text-dark h6">
                            <th>&nbsp;</th>
                            <th>Invoice Number</th>
                            <th>Client Name</th>
                            <th>Project Name</th>
                            <th>Date</th>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                        </tr>
                        @foreach ( $invoices_mini as $key => $invoice_mini )
                        <tr>
                            <td>{{ $invoices_mini->firstItem() + $key }}</td>
                            <td>EFC00{{ $invoice_mini->invoice_number }}</td>
                            <td>{{ $invoice_mini->client_name }}</td>
                            <td>{{ $invoice_mini->project_name }}</td>
                            <td>{{ $invoice_mini->created_at }}</td>
                            <td><button type="button" name="details" id="details" class="btn btn-primary">Details</button></td>
                            <td><button type="button" name="export" id="export" class="btn btn-success">Export</button></td>
                        </tr>
                        @endforeach
                    </table>

                    {{-- Pagination --}}
                    <div class="d-flex justify-content-center">
                        {!! $invoices_mini->links() !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">{{ __('SEARCH') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <!-- {{ __('You are logged in!') }} -->

                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="{{Str::limit('Search by invoice number, client name', 20, '...')}}">
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="button"><i class="fas fa-search" aria-hidden="true"></i></button>
                        </span>
                    </div>

                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header">{{ __('TOOLS') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <!-- {{ __('You are logged in!') }} -->

                    <!-- <div class="input-group">
                        <input type="text" class="form-control" placeholder="{{Str::words('Search by invoice number, client name', '3', '...')}}">
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="button"><i class="fas fa-search" aria-hidden="true"></i></button>
                        </span>
                    </div> -->

                    <div><a class="btn btn-primary" href="{{ route('create') }}">New Invoice</a></div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
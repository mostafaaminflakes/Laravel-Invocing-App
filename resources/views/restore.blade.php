@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="">
                <div class="d-flex justify-content-between">
                    <div><strong>{{ __('Invoices Restore and Delete') }}</strong></div>
                    <div class="fw-light fs-6 mt-1">{{ __('Total invoices') }}: {{ $invoices_mini->total() }}</div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <div class="table-responsive mb-3">
                        @if($invoices_mini->count() > 0)
                        <table class="table table-striped table-hover align-middle" id="dynamicTable">
                            <!-- table-sm -->
                            <thead class="table-primary">
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('Invoice Number') }}</th>
                                    <th class="col-sm-3">{{ __('Client Name') }}</th>
                                    <th class="col-sm-3">{{ __('Project Name') }}</th>
                                    <th>{{ __('Date') }}</th>
                                    <th>&nbsp;</th>
                                    <th>&nbsp;</th>
                                    <th>&nbsp;</th>
                                    <th>&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ( $invoices_mini as $key => $invoice_mini )
                                <tr class="h6">
                                    <td>{{ $invoices_mini->firstItem() + $key }}</td>
                                    <td>EFC00{{ $invoice_mini->invoice_number }}</td>
                                    <td>{{ $invoice_mini->client_name }}</td>
                                    <td>{{ $invoice_mini->project_name }}</td>
                                    <td>{{ $invoice_mini->created_at }}</td>
                                    <td><a href="{{ route('admin_details', 'EFC00'.$invoice_mini->invoice_number) }}" class="btn btn-primary btn-sm">{{ __('Details') }}</a></td>
                                    <td><a href="{{ route('admin_restore_invoice', 'EFC00'.$invoice_mini->invoice_number) }}" class="btn btn-warning btn-sm">{{ __('Restore') }}</a></td>
                                    <td><a href="{{ route('admin_delete_invoice', 'EFC00'.$invoice_mini->invoice_number) }}" onclick="return confirm('{{ __('Are you sure to delete this invoice?') }}')" class="btn btn-danger btn-sm">{{ __('Permanent Delete') }}</a></td>
                                    <td><a href="{{ route('download-invoice', 'EFC00'.$invoice_mini->invoice_number) }}" class="btn btn-success btn-sm">{{ __('Export') }}</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <p>{{ __('No invoices found...') }}</p>
                        @endempty
                    </div>

                    {{-- Pagination --}}
                    <div class="d-flex justify-content-center">
                        {!! $invoices_mini->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
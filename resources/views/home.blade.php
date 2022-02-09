@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="">
                <div class="d-flex justify-content-between">
                    <div><strong>{{ __('INVOICES') }}</strong></div>
                    <div class="fw-light fs-6 mt-1">{{ __('Total invoices') }}: {{ $invoices_mini->total() }}</div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <div class="table-responsive mb-3">
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
                                    @if( settings()->get('sfc_allow_edit') == 'on' )
                                    <th>&nbsp;</th>
                                    @endif
                                    @if( settings()->get('sfc_allow_delete') == 'on' )
                                    <th>&nbsp;</th>
                                    @endif
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
                                    <td><a href="{{ route('details', 'EFC00'.$invoice_mini->invoice_number) }}" class="btn btn-primary btn-sm">{{ __('Details') }}</a></td>
                                    @if( settings()->get('sfc_allow_edit') == 'on' )
                                    <td><a href="{{ route('details', 'EFC00'.$invoice_mini->invoice_number) }}" class="btn btn-primary btn-sm">{{ __('Edit') }}</a></td>
                                    @endif
                                    @if( settings()->get('sfc_allow_delete') == 'on' )
                                    <td><a href="{{ route('details', 'EFC00'.$invoice_mini->invoice_number) }}" class="btn btn-danger btn-sm">{{ __('Delete') }}</a></td>
                                    @endif
                                    <td><a href="{{ route('download-invoice', 'EFC00'.$invoice_mini->invoice_number) }}" class="btn btn-success btn-sm">{{ __('Export') }}</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="d-flex justify-content-center">
                        {!! $invoices_mini->links() !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">{{ __('SEARCH') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <form action="{{ route('search') }}" method="post">
                        @csrf
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="{{ __('SEARCH') }}">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="submit"><i class="fas fa-search" aria-hidden="true"></i></button>
                            </span>
                        </div>
                    </form>

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

                    <!-- <div class="input-group">
                        <input type="text" class="form-control" placeholder="{{Str::words('Search by invoice number, client name', '3', '...')}}">
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="button"><i class="fas fa-search" aria-hidden="true"></i></button>
                        </span>
                    </div> -->

                    <div><a class="btn btn-primary" href="{{ route('create') }}">{{ __('New Invoice') }}</a></div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('INVOICES') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <!-- {{ __('You are logged in!') }} -->
                    Welcome <strong>{{ Auth::user()->name }}</strong>
                    <p><a href="{{ route('download-invoice') }}">Download Invoice</a></p>
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

                    <div class="mt-3"><button type="button" class="btn btn-primary">New Invoice</button></div>

                </div>
            </div>
            <div class="card">
                <div class="card-header">{{ __('TOOLS') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <!-- {{ __('You are logged in!') }} -->

                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="{{Str::words('Search by invoice number, client name', '3', '...')}}">
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="button"><i class="fas fa-search" aria-hidden="true"></i></button>
                        </span>
                    </div>

                    <div class="mt-3"><button type="button" class="btn btn-primary">New Invoice</button></div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
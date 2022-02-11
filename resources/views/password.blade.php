@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="d-flex justify-content-between card-header">
                    <div><strong>{{ __('Change Password') }}</strong></div>
                    <!-- <div class="fw-light fs-6 mt-1">{{ __('Total invoices') }}: </div> -->
                </div>

                <form action="{{ route('change_password') }}" method="post">
                    @csrf
                    <div class="card-body">
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <div class="col-11 mx-auto">
                            <div class="d-grid gap-1 mb-3">
                                <div class="p-2">
                                    <div class="row">
                                        <label for="current_password" class="col-sm-2">{{ __('Current Password') }} <span class="fw-light fs-6 text-danger">*</span></label>
                                        <div class="col-sm-10">
                                            <input type="password" name="current_password" id="current_password" class="form-control" placeholder="{{ __('Current Password') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="p-2">
                                    <div class="row">
                                        <label for="new_password" class="col-sm-2">{{ __('New Password') }} <span class="fw-light fs-6 text-danger">*</span></label>
                                        <div class="col-sm-10">
                                            <input type="password" name="new_password" id="new_password" class="form-control" placeholder="{{ __('New Password') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="p-2">
                                    <div class="row">
                                        <label for="confirm_new_password" class="col-sm-2">{{ __('Confirm New Password') }} <span class="fw-light fs-6 text-danger">*</span></label>
                                        <div class="col-sm-10">
                                            <input type="password" name="confirm_new_password" id="confirm_new_password" class="form-control" placeholder="{{ __('Confirm New Password') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mx-auto border-top pt-3">
                                <button type="submit" class="btn btn-primary" id="submit">{{ __('Save') }}</button>
                                <div id="spinner"></div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
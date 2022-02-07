@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="d-flex justify-content-between card-header">
                    <div><strong>{{ __('SETTINGS') }}</strong></div>
                    <!-- <div class="fw-light fs-6 mt-1">{{ __('Total invoices') }}: </div> -->
                </div>

                <form action="{{ route('save_settings') }}" method="post">
                    @csrf
                    @method('PUT')
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
                            <div class="row mb-3">
                                <div class="col-12 fw-bold border-bottom">{{ __('Account Settings') }}</div>
                            </div>
                            <div class="d-grid gap-1 mb-3">
                                <div class="p-2">
                                    <div class="row">
                                        <label for="name" class="col-sm-2">{{ __('Name') }}</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="name" id="name" class="form-control" value="{{ (old('name') ? old('name') : Auth::user()->name ) }}" placeholder="{{ __('Name') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="p-2">
                                    <div class="row">
                                        <label for="email" class="col-sm-2">{{ __('Email') }}</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="email" id="email" class="form-control" value="{{ (old('email') ? old('email') : Auth::user()->email ) }}" placeholder="{{ __('Email') }}">
                                            <!-- <span>If you changed your email address, verification is required.</span> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="p-2">
                                    <div class="row">
                                        <div class="col-sm-2">{{ __('Password') }}</div>
                                        <div class="col-sm-10"><a href="#">{{ __('Change Password') }}</a></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 fw-bold border-bottom mb-3">{{ __('General Settings') }}</div>
                            </div>
                            <div class="d-grid gap-3 mb-3">
                                <!-- <div class="p-2">
                                <div class="row">
                                    <label for="client_name" class="col-sm-2">{{ __('Default Language') }}</label>
                                    <div class="col-sm-10">
                                        <div class="">
                                            <input class="form-check-input" type="radio" name="default_language" id="en" {{ old('default_language') == 'en' || config('efc.default_language') == 'en' ? 'checked' : ''}}>
                                            <label class="form-check-label pe-2" for="en">
                                                {{ __('English') }}
                                            </label>
                                        </div>
                                        <div class="">
                                            <input class="form-check-input" type="radio" name="default_language" id="ar" {{ old('default_language') == 'ar' || config('efc.default_language') == 'ar' ? 'checked' : ''}}>
                                            <label class="form-check-label pe-2" for="ar">
                                                {{ __('Arabic') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                                <div class="p-2">
                                    <div class="row">
                                        <label for="vat" class="col-sm-2 col-form-label">{{ __('VAT') }}</label>
                                        <div class="col-5">
                                            <div class="input-group">
                                                <input type="text" name="vat" id="vat" class="form-control" value="{{ (old('vat') ? old('vat') : $settings->get('sfc_vat') ) }}" placeholder="{{ __('VAT') }}">
                                                <div><span class="input-group-text">%</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-2">
                                    <div class="row">
                                        <div class="col-sm-2">{{ __('Search In') }}</div>
                                        <div class="col-sm-10">
                                            @foreach(config('efc.search_meta') as $key => $item)
                                            <div class="form-check form-switch d-flex">
                                                <input class="form-check-input" type="checkbox" id="{{ $key }}_chkbx" name="{{ $key }}_chkbx" {{ old( $key . '_chkbx') == 'on' || config('efc.search_meta.'. $key . '.checked') ? 'checked' : '' }} {{ config('efc.search_meta.'. $key . '.enabled') ? '' : 'disabled' }}>
                                                <label class="form-check-label me-5" for="{{ $key }}_chkbx">{{ __(config('efc.search_meta.'. $key . '.ui_text')) }}</label>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="p-2">
                                    <div class="row">
                                        <div class="col-sm-2">{{ __('Edit Function') }}</div>
                                        <div class="col-sm-10">
                                            <div class="form-check form-switch d-flex">
                                                <input class="form-check-input" type="checkbox" id="enable_edit_button" name="enable_edit_button" {{ old('enable_edit_button') == 'on' || config('efc.allow_edit') ? 'checked' : ''}}>
                                                <label class="form-check-label me-5" for="enable_edit_button">{{ __('Enable Edit Button') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-2">
                                    <div class="row">
                                        <div class="col-sm-2">{{ __('Delete Function') }}</div>
                                        <div class="col-sm-10">
                                            <div class="form-check form-switch d-flex">
                                                <input class="form-check-input" type="checkbox" id="enable_delete_button" name="enable_delete_button" {{ old('enable_delete_button') == 'on' || config('efc.allow_delete') ? 'checked' : ''}}>
                                                <label class="form-check-label me-5" for="enable_delete_button">{{ __('Enable Delete Button') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 fw-bold border-bottom mb-3">{{ __('Bank Settings') }}</div>
                            </div>
                            <div class="d-grid gap-1 mb-3">
                                <div class="p-2">
                                    <div class="row">
                                        <label for="bank_name" class="col-sm-2">{{ __('Bank Name') }}</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="bank_name" id="bank_name" class="form-control" value="{{ (old('bank_name') ? old('bank_name') : config('efc.bank_name') ) }}" placeholder="{{ __('Bank Name') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="p-2">
                                    <div class="row">
                                        <label for="iban" class="col-sm-2">{{ __('IBAN') }}</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="iban" id="iban" class="form-control" value="{{ (old('iban') ? old('iban') : config('efc.iban') ) }}" placeholder="{{ __('IBAN') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 fw-bold border-bottom mb-3">{{ __('Invoice Settings') }}</div>
                            </div>
                            <div class="d-grid gap-1 mb-3">
                                <div class="p-2">
                                    <div class="row">
                                        <label for="seller_name" class="col-sm-2">{{ __('Seller Name') }}</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="seller_name" id="seller_name" class="form-control" value="{{ (old('seller_name') ? old('seller_name') : config('efc.seller_name') ) }}" placeholder="{{ __('Seller Name') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="p-2">
                                    <div class="row">
                                        <label for="seller_vat" class="col-sm-2">{{ __('Seller VAT') }}</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="seller_vat" id="seller_vat" class="form-control" value="{{ (old('seller_vat') ? old('seller_vat') : config('efc.seller_vat') ) }}" placeholder="{{ __('Seller VAT') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="p-2">
                                    <div class="row">
                                        <label for="cr_number" class="col-sm-2">{{ __('CR Number') }}</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="cr_number" id="cr_number" class="form-control" value="{{ (old('cr_number') ? old('cr_number') : config('efc.cr_number') ) }}" placeholder="{{ __('CR Number') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="p-2">
                                    <div class="row">
                                        <label for="serial_number" class="col-sm-2">{{ __('Serial Number') }}</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="serial_number" id="serial_number" class="form-control" value="{{ (old('serial_number') ? old('serial_number') : config('efc.serial') ) }}" placeholder="{{ __('Serial Number') }}" readonly>
                                            <span>{{ __('Starting series for the invoice number') }}</span> <span>[<span class="fw-bold">EFC00</span><span>1234</span>]</span>
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
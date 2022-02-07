<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'vat' => 'required|numeric',
            'bank_name' => 'required|string|max:500',
            'iban' => 'required|string|max:255',
            'seller_name' => 'required|string|max:500',
            'seller_vat' => 'required|digits:15',
            'cr_number' => 'required|numeric',
            'serial_number' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('Name is required.'),
            'email.required' => __('Email is required.'),
            'email.email' => __('Email is not in the correct format.'),
            'vat.required' => __('VAT percentage is required.'),
            'bank_name.required' => __('Bank name is required.'),
            'iban.required' => __('IBAN identifier is required.'),
            'seller_name.required' => __('Seller name is required.'),
            'seller_vat.required' => __('Seller VAT is required.'),
            'seller_vat.digits' => __('VAT number must be 15 digits.'),
            'cr_number.required' => __('CR number is required.'),
            'serial_number.required' => __('Serial number is required.'),
        ];
    }
}

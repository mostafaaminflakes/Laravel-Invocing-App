<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\MatchOldPassword;

class PasswordRequest extends FormRequest
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
            'current_password' => ['required', 'string', 'max:255', new MatchOldPassword],
            'new_password' => 'required|string|max:255|min:6',
            'confirm_new_password' => 'required|string|max:255|same:new_password',
        ];
    }

    public function messages()
    {
        return [
            'current_password.required' => __('Current password is required.'),
            'new_password.required' => __('New password is required.'),
            'new_password.min' => __('New password must be at least 6 letters or numbers.'),
            'confirm_new_password.required' => __('Confirm new password is required.'),
            'confirm_new_password.same' => __('New passwords doesn\'t match.'),
        ];
    }
}

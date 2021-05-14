<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Hãy điền tên của bạn.',
            'email.required' => 'Hãy điền email của bạn.',
            'email.email' => 'Email không đúng định dạng.',
            'phone.required' => 'Hãy điền số điện thoại của bạn.',
            'address.required' => 'Hãy điền địa chỉ của bạn.',
        ];
    }
}

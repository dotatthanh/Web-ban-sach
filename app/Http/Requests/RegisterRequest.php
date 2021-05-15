<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
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
            'phone' => 'required',
            'address' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|max:32',
            'password_confirm' => 'required|same:password',
        ];
    }

    public function messages() {
        return [
            'email.unique' => 'Địa chỉ email đã tồn tại, vui lòng nhập địa chỉ khác.',
        ];
    }
}

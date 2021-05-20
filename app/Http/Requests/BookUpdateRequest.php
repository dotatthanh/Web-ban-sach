<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookUpdateRequest extends FormRequest
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
            'name' => 'required|max:100',
            'img' => 'required',
            'price' => 'required|min:1',
            'sale' => 'required|min:0',
            'content' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên sách không được trống.',
            'name.max'  => 'Tên sách không được phép vượt quá 100 kí tự.',
            'img.required'  => 'Ảnh không được trống.',
            'price.required'  => 'Đơn giá không được trống.',
            'price.min'  => 'Đơn giá lớn hơn 0.',
            'sale.required'  => 'Giảm giá không được trống.',
            'sale.min'  => 'Giảm giá lớn hơn hoặc bằng 0.',
            'content.required'  => 'Tóm tắt nội dung không được trống.',
        ];
    }
}

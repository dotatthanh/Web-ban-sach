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
            'nameupdate' => 'required|max:100',
            'imgupdate' => 'required',
            'priceupdate' => 'required|min:1',
            'saleupdate' => 'required|min:0',
            'contentupdate' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'nameupdate.required' => 'Tên sách không được trống.',
            'nameupdate.max'  => 'Tên sách không được phép vượt quá 100 kí tự.',
            'imgupdate.required'  => 'Ảnh không được trống.',
            'priceupdate.required'  => 'Đơn giá không được trống.',
            'priceupdate.min'  => 'Đơn giá lớn hơn 0.',
            'saleupdate.required'  => 'Giảm giá không được trống.',
            'saleupdate.min'  => 'Giảm giá lớn hơn hoặc bằng 0.',
            'contentupdate.required'  => 'Tóm tắt nội dung không được trống.',
        ];
    }
}

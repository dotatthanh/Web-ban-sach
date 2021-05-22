<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
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
            'name' => 'required|unique:books|max:100',
            'img' => 'required',
            // 'amount' => 'required|min:1',
            'price' => 'required|min:1',
            // 'cover_price' => 'required|min:1',
            'sale' => 'min:0',
            'content' => 'required',
            'size' => 'required',
            'page_number' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên sách không được trống.',
            'size.required' => 'Kích thước sách không được trống.',
            'page_number.required' => 'Số trang không được trống.',
            'name.unique' => 'Sách đã tồn tại.',
            'name.max'  => 'Tên sách không được phép vượt quá 100 kí tự.',
            'img.required'  => 'Ảnh không được trống.',
            // 'amount.required'  => 'Số lượng không được trống.',
            // 'amount.min'  => 'Số lượng lớn hơn 0.',
            'price.required'  => 'Đơn giá không được trống.',
            'price.min'  => 'Đơn giá lớn hơn 0.',
            // 'cover_price.required'  => 'Giá bìa không được trống.',
            // 'cover_price.min'  => 'Giá bìa lớn hơn 0.',
            'sale.min'  => 'Giảm giá lớn hơn hoặc bằng 0.',
            'content.required'  => 'Tóm tắt nội dung không được trống.',
        ];
    }
}

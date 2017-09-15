<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClassifyRequest extends FormRequest
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
            'name' => 'required|max:20',
            'comment' => 'max:191',
            'icon' => 'max:100',
            'sorting' => 'numeric|min:0|max:10000',
            'enabled' =>'numeric|min:0|max:1'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '分类名称必须填写',
            'name.max' => '分类名称不能大于20个字符',
            'comment.max' => '分类备注不能大于180个字符',
            'icon.max' => '分类图标不能大于100个字符',
            'sorting.numeric' => '分类排序必须为数字',
            'sorting.min' => '分类排序最小值为0',
            'sorting.max' => '分类排序最大值为10000',
            'enabled.numeric' => '请勿错误操作',
            'enabled.min' => '请勿错误操作',
            'enabled.max' => '请勿错误操作',
        ];
    }
}

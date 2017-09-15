<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssetRequest extends FormRequest
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
            'name'=>'required',
            'category_id'=>'required',
            'area_id'=>'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'请输入资产名称',
            'category_id.required'=>'请选择资产类别',
            'area_id.required'=>'请选择所在场地',
        ];
    }
}

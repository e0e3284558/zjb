<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssetClearRequest extends FormRequest
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
            'clear_time'=>'required',
            'asset_ids'=>'required'
        ];
    }

    public function messages()
    {
        return [
            'clear_time.required'=>'请选择清理日期',
            'asset_ids.required'=>'请选择清理资产'
        ];
    }
}

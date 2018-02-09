<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
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
        switch ($this->method()){
            case 'GET':
            case 'DELETE':
            {
                return [];
            }
            case 'POST':
            {
                return [
                    'name'=>'bail|required',
                    'code'=>'bail|required',
                    'pid'=>'bail|required',
                    'status'=>'bail|required',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name'=>'bail|required',
                    'code'=>'bail|nullable|unique:brands,code,'.request('id'),
                    'pid'=>'bail|required|different:id',
                    'status'=>'bail|required',
                ];
            }
            default:break;
        }
    }

    public function messages()
    {
        return [
            'name.required'=>'请输入品牌名称',
            'code.required'=>'请输入品牌编码',
            'code.unique'=>'品牌编码已存在',
            'pid.required'=>'请选择上级品牌',
            'pid.different'=> '上级品牌不能为自身',
            'status.required'=>'请选择状态',
        ];
    }
}

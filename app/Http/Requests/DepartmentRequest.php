<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
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
                    'parent_id'=>'bail|required',
                    'status'=>'bail|required',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name'=>'bail|required',
                    'parent_id'=>'bail|required|different:id',
                    'status'=>'bail|required',
                ];
            }
            default:break;
        }

    }

    /**
     * 获取已定义验证规则的错误消息。
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => '请输入部门名称',
            'parent_id.required' => '请选择上级部门',
            'parent_id.different'=> '上级部门不能为自身',
            'status.required' => '请选择部门状态',
        ];
    }
}

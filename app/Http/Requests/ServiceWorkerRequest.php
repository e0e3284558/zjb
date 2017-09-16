<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceWorkerRequest extends FormRequest
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
        switch ($this->method()) {
            case 'POST':
                return [
                    'username' => 'required|min:6|max:20|unique:service_workers',
                    'password' => 'required|min:6|max:20',
                    'name' => 'required|min:2|max:10',
                    'tel' => 'required|numeric|digits:11|unique:service_workers',
                ];
            case 'PUT':
                return [
                    'username' => 'required|min:6|max:20|unique:service_workers',
                    'password' => 'nullable|min:6',
                    'name' => 'required|min:2|max:10',
                    'tel' => 'required|numeric|digits:11|unique:service_workers',
                ];
        }

    }

    public function messages()
    {
        return [
            'username.required' => '用户名必须填写',
            'username.min' => '用户名不能小于6位',
            'username.max' => '用户名不能大于20位',
            'username.unique' => '用户名已存在',
            'password.required' => '密码必须填写',
            'password.min' => '密码不能小于6位',
            'name.required' => '姓名必须填写',
            'name.min' => '姓名不能小于2位',
            'name.max' => '姓名不能大于10位',
            'tel.required' => '手机号码必须填写',
            'tel.numeric' => '手机号码必须为数字',
            'tel.digits' => '手机号码不正确，请查看是否正确',
            'tel.unique' => '手机号码已存在'
        ];
    }
}

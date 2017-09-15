<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRepairRequest extends FormRequest
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
//            'area_id'=>'required',
//            'classify_id '=>'nullable|numeric|min:1',
//            'asset_id '=>'nullable|numeric|min:1',
//            'remarks '=>'nullable|max:191',
//            'other '=>'numeric|min:0|max:1',
//            'provider_id'=>'required|numeric|min:1',
//            'service_worker_id'=>'required|numeric|min:1',
//            'service_provider_id'=>'required|numeric|min:1',
        ];
    }
    public function messages()
    {
        return [
//            'area_id.required'=>'请选择正确的场地信息',
//            'area_id.numeric'=>'请选择正确的场地信息',
//            'classify_id.numeric'=>'请选择正确的分类信息',
//            'classify_id.min'=>'请选择正确的分类信息',
//            'asset_id.numeric'=>'请选择正确的资产信息',
//            'asset_id.min'=>'请选择正确的资产信息',
//            'remarks.max'=>'备注内容不可以超过190个字符',
//            'other.min'=>'请勿操作隐藏域数据内容',
//            'other.max'=>'请勿操作隐藏域数据内容',
//            'provider_id.required'=>'请选择正确的服务商',
//            'provider_id.numeric'=>'请选择正确的服务商',
//            'provider_id.min'=>'请选择正确的服务商',
//            'service_worker_id.required'=>'请选择正确的维修工',
//            'service_worker_id.numeric'=>'请选择正确的维修工',
//            'service_worker_id.min'=>'请选择正确的维修工',
//            'service_provider_id.required'=>'请选择正确的服务商',
//            'service_provider_id.numeric'=>'请选择正确的服务商',
//            'service_provider_id.min'=>'请选择正确的服务商',

        ];
    }
}

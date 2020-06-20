<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectRequest extends FormRequest
{
    protected $errorBag = 'default';

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
                $this->errorBag = 'create';
                 return [
                    'name' => ['required',
                                Rule::unique('projects')->where(function ($query) {
                                    $query->where('user_id', request()->user()->id);
                                })],
                    'thumbail' => 'image|dimensions:min_weight=250,min_height=100|max:2048',
                ];
                break;

            case 'PUT':
            case 'PATCH':
                $this->errorBag = 'update-' . $this->route('project');
                return [
                        'name' => ['required',
                                    Rule::unique('projects')->ignore($this->route('project'))->where(function ($query) {
                                        $query->where('user_id', request()->user()->id);
                                    })],
                        'thumbail' => 'image|dimensions:min_weight=250,min_height=100|max:2048',
                    ];
                    break;
            default:
                return [];
                break;
        }

    }

    public function messages()
    {
        return [
            'name.required' => '项目名称是必填的',
            'name.unique' => '项目名称已存在',
            'thumbnail.iamge' => '请上传图片文件',
            'thumbnail.dimensions' => '图片的尺寸大小不小于250X100像素',
            'thumbnail.max' => '不要上传超过2M的图片',
        ];
    }
}

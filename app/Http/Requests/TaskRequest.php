<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskRequest extends FormRequest
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
                $this->errorBag = 'create';
                return [
                    'name' => 'required|max:255',
                    'project' => 'required|integer|exists:projects,id'
                ];
                break;
            case 'PATCH':
                $this->errorBag = 'update-' . $this->route('task');
                //dd($this->errorBag);
                return [
                    'name' => 'required|max:255',
                    'project_id' => [
                        'required',
                        'integer',
                    Rule::exists('projects', 'id')->whereIn('id', $this->user()->projects()->pluck('id')->toArray())
                    ],
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
            'name.required' => '任务名称不能为空',
            'name.max' => '任务长度超出最大值255个字符',
            'project.required' => '没有提交当前任务所属项目的id',
            'project.integer' => '所提交的项目id无效（非整数）',
            'project.exists' => '此项目不属于当前用户',
            'project_id.required' => '没有提交当前任务所属项目的id',
            'project_id.integer' => '所提交的项目id无效（非整数）',
            'project_id.exists' => '此项目不属于当前的用户',
        ];

    }
}

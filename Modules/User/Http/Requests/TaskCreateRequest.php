<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
class TaskCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => 'required|string|max:64',
            "details" => 'nullable|max:1024',
            //"category_name" => 'nullable',
            //"priority" => 'required',
            //"status" => 'required',
            //"version" => 'nullable',
            //"start_date" => 'nullable|before_or_equal:end_date',
            "end_date" => 'nullable|after_or_equal:start_date',
            "deadline" => 'nullable|after_or_equal:end_date',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function attributes(){
        return [
            "name" => '',
            "details" => '',
            "category_name" => '',
            "priority" => '',
            "status" => '',
            "version" => '',
        ];
    }

    public function messages()
    {
        return [
            //"start_date.before"=>"開始日を終了日より前に設定してください",
            "start_date.before_or_equal"=>"開始日を終了日より前に設定してください",
            //"end_date.after"=>"終了日を開始日より後に設定してください",
            "end_date.after_or_equal"=>"終了日を開始日より後に設定してください",
            //"deadline.after"=>"締切日を終了日より後に設定してください",
            "deadline.after_or_equal"=>"締切日を終了日より後に設定してください",
        ];
    }
}

<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
class UpdatePassRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "password" => "required|string|min:8|max:64",
            "password_confirmation" => "required|min:8|max:64|same:password",
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
            "email" => "",
            "password" => "",
            "term_of_use" => "",
            "password_confirmation" => '',
        ];
    }

    public function messages()
    {
        return [
            //"password.confirmed" => "パスワードが一致しません",
            'password_confirmation.same' => 'パスワードが一致しません',
            'term_of_use.required' => 'チェックしてください',
        ];
    }
}

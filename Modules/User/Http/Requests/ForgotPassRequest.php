<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
class ForgotPassRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "email" => "required|email|exists:users",
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
        ];
    }

    public function messages()
    {
        return [
            'email.exists' => 'Địa chỉ email chưa được đăng ký',
        ];
    }
}

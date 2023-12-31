<?php

namespace Modules\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
class UserUpdateRequest extends FormRequest
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
        ];
    }

    public function messages()
    {
        return [
        ];
    }
}

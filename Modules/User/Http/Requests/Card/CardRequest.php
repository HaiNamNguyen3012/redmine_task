<?php

namespace Modules\User\Http\Requests\Card;

use Illuminate\Foundation\Http\FormRequest;

class CardRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $flag = true;
        if (!empty(request()->all())) {
            $data = request()->all();
            if ($data["year"] == date('y')) {
                $flag = false;
            }
        }

        if ($flag) {
            return [
                'card_number' => 'required|numeric',
                'card_name' => 'required|string|min:3|max:255',
                'month' => 'required|numeric|digits_between:1,2|min:1|max:12',
                'year' => 'required|numeric|digits:2|min:' . date('y'),
                'card_cvc' => 'required|numeric|digits_between:3,4',
                //'agree' => 'required',
            ];
        } else {
            return [
                'card_number' => 'required|numeric',
                'card_name' => 'required|string|min:3|max:255',
                'month' => 'required|numeric|digits_between:1,2|min:' . date('m') . '|max:12',
                'year' => 'required|numeric|digits:2|min:' . date('y'),
                'card_cvc' => 'required|numeric|digits_between:3,4',
                //'agree' => 'required',
            ];
        }
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

    public function attributes()
    {
        return [
            'card_number' => '',
            'card_name' => '',
            'month' => '',
            'year' => '',
            'card_cvc' => '',
            'agree' => '',
        ];
    }

    public function messages()
    {
        $flag = true;
        if (!empty(request()->all())) {
            $data = request()->all();
            if ($data["year"] == date('Y')) {
                $flag = false;
            }
        }

        $mess = [
            'agree.required' => 'チェックしてください',
            'year.min' => '過去の年月は入力できません',
        ];

        if (!$flag) {
            $mess['month.min'] = "過去の年月は入力できません";
        }

        return $mess;
    }

}

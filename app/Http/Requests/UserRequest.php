<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'last_name' => 'required',
            'first_name' => 'required',
            'last_kana_name' => 'required',
            'first_kana_name' => 'required',
            'gender' => [
                'required',
                'regex:/^(male|female)$/',
            ],
            'birthdate_year' => 'regex:/^[0-9]{4}$/',
            'birthdate_month' => [
                'regex:/^([1-9]|1[0-2])$/',
            ],
            'email' => [
                'required',
                'regex:/^[a-zA-Z0-9_.+-]+@([a-zA-Z0-9][a-zA-Z0-9-]*[a-zA-Z0-9]*\.)+[a-zA-Z]{2,}$/',
            ],

        ];
    }

    public function attributes()
    {
        return [
            'last_name' => '姓',
            'first_name' => '名前',
            'last_kana_name' => '姓カナ',
            'first_kana_name' => '名前カナ',
        ];
    }
}

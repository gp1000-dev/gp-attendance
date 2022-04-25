<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfile extends FormRequest
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

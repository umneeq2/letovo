<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * PupilCreateUpdateRequest
 */
class PupilCreateUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'fullname' => 'required|min:10|max:100',
            'address' => 'required|min:10|max:200',
            'mobile_phone' => 'required|min:10|max:20',
        ];

        // если Update, мы должны исключить себя при поиске уникальности email-а
        if ($this->pupil) {
            $rules['email'] = ['required', 'email', \Illuminate\Validation\Rule::unique('pupils')->ignore($this->pupil)];
        } else {
            $rules['email'] = 'required|email|unique:pupils';
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'fullname' => 'ФИО',
            'mobile_phone' => 'Мобильный номер телефона',
        ];
    }
}

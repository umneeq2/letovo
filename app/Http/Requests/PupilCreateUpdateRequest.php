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
        return [
            'fullname' => 'required|min:10|max:100',
            'address' => 'required|min:10|max:200',
            // если Update, мы должны исключить себя при поиске уникальности email-а
            'email' => 'required|email|unique:pupils' . ($this->pupil ? ',email,' . $this->pupil->id : ''),
            'mobile_phone' => 'required|min:10|max:20',
        ];
    }

    public function attributes()
    {
        return [
            'fullname' => 'ФИО',
            'mobile_phone' => 'Мобильный номер телефона',
        ];
    }
}

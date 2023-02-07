<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email' => 'required|email|unique:users,email',
            'data_user_agreement' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
          'email.unique' => 'Пользователь с такой почтой уже зарегистрирован',
          'email.*' => 'Указан неверный формат почты',
        ];
    }
}

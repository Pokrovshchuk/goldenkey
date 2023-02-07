<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderMakeRequest extends FormRequest
{
    const TINKOFF = 'tinkoff';
    const YOOKASSA = 'yookassa';

    public static $banks = [
        self::TINKOFF,
        self::YOOKASSA,
    ];

    public function rules(): array
    {
        return [
            'bank' => ['required', 'string', Rule::in(self::$banks)],
            'product_id' => 'required|numeric',
            'email' => ['email', Rule::requiredIf(!auth()->check())],
            'quantity' => 'sometimes|numeric',
            'more_than_one' => 'sometimes|boolean',
            'named' => 'sometimes|boolean',
            'name' => 'sometimes|string',
            'from_stand' => 'sometimes|boolean',
            'installments' => 'sometimes|boolean',
        ];
    }

    public function messages()
    {
        return [
            'bank' => 'Оплата через выбранный банк недоступна',
        ];
    }
}

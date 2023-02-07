<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TinkoffNotificationRequest extends FormRequest
{
    private static $statuses = ['AUTHORIZED', 'CONFIRMED', 'REVERSED', 'REFUNDED', 'PARTIAL_REFUNDED', 'REJECTED'];

    public function rules(): array
    {
        return [
            'TerminalKey' => 'string',
            'OrderId' => 'string',
            'Success' => 'boolean',
            'Status' => ['string', Rule::in(self::$statuses)],
            'PaymentId' => 'numeric',
            'ErrorCode' => 'string',
            'Amount' => 'numeric',
            'Pan' => 'string',
            'Token' => 'string',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class YookassaNotificationRequest extends FormRequest
{
    private $events = [
        self::STATUS_WAITING,
        self::STATUS_SUCCEEDED,
        self::STATUS_CANCELED,
        self::STATUS_REFUND,
    ];

    const STATUS_WAITING = 'payment.waiting_for_capture';
    const STATUS_SUCCEEDED = 'payment.succeeded';
    const STATUS_CANCELED = 'payment.canceled';
    const STATUS_REFUND = 'refund.succeeded';

    public function rules(): array
    {
        return [
            'type' => 'required|string',
            'event' => ['required', 'string', Rule::in($this->events)],
            'object' => 'array',
            'object.id' => 'required|string', // payment id
            'object.status' => 'required|string',
            'object.paid' => 'required|boolean',
            'object.amount' => 'array',
            'object.amount.value' => '',
            'object.amount.currency' => '',
            'object.authorization_details' => '',
            'object.authorization_details.rrn' => '',
            'object.authorization_details.auth_code' => '',
            'object.description' => '',
            'object.metadata' => 'array',
            'object.metadata.orderId' => 'numeric',
            'object.payment_method' => '',
            'object.refundable' => '',
            'object.test' => 'boolean',
        ];
    }
}

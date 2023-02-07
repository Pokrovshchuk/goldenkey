<?php

namespace App\Http\Controllers;

use App\Http\Requests\CallbackRequest;
use App\Mail\Callback;
use App\Mail\CertificateCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CallbackController extends Controller
{
    public function sendCallback(CallbackRequest $request)
    {
        Mail::to('info@goldenkey.world')
            ->queue(new Callback($request->email, $request->name, $request->phone, $request->text));

        return response()->json([
            'status' => 'scuccess',
            'message' => 'Письмо успешно отправлено. Мы вскоре свяжемся с Вами.'
        ]);
    }
}

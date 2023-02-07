<?php

namespace App\Http\Controllers;

use App\Events\CertificateChangeStatusEvent;
use App\Events\CertificateScannedEvent;
use App\Exports\CertificatesExport;
use App\Http\Requests\CertificateCodeCheckRequest;
use App\Http\Requests\CertificateIdRequest;
use App\Mail\CertificateCreated;
use App\Models\Certificate;
use App\Models\Hall;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class CertificateController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return view('admin.certificates.index', [
            'products' => $products,
        ]);
    }

    public function store(Order $order)
    {
        $certificateArr = [];
        if ($order->quantity > 1 and $order->order_meta->more_than_one) {
            $names = json_decode($order->order_meta->name);

            for ($i = 0; $i < $order->quantity; $i++) {
                $order_tmp = new Order();
                $order_tmp->id = $order->id;
                $order_tmp->product_id = $order->product_id;
                $order_tmp->quantity = 1;
                $order_tmp->order_meta->name = $names[$i] ?? null;
                $order_tmp->order_meta->from_stand = $order->order_meta->from_stand;

                $certificateArr[] = Certificate::new($order_tmp);
            }
        } else {
            $certificateArr[] = Certificate::new($order);
        }


        // Send certificate if order wasn't from stand
        if (!$order->order_meta->from_stand) {
            foreach ($certificateArr as $certificate) {
                Mail::to($order->email)->queue(new CertificateCreated($certificate));
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Сертификат(ы) успешно отправлен.'
        ]);
    }

    public function edit(CertificateIdRequest $request)
    {
        $certificate = Certificate::where('id', $request->id)->first();

        if (!$certificate) {
            return response()->json([
                'status' => 'error',
                'message' => 'Такого сертификата не существует.'
            ], 422);
        }

        $certificate->table_number = $request->table_number;
        $certificate->description = $request->description;
        $certificate->save();

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function codeCheck(CertificateCodeCheckRequest $request)
    {
        $hash = Certificate::makeHash($request->code);
        $certificate = Certificate::where('hash', $hash)->where('hall_id', \auth()->user()->hall->id)->with('user')->first();

        $user_id = \auth()->user()->id;

        if (!$certificate) {
            $message = [
                'status' => 'error',
                'code' => 1001,
                'message' => Certificate::ERRORS['isNull']
            ];
            if ($request->from_stand) CertificateScannedEvent::broadcast($message, $user_id);

            return response()->json($message);
        }

        if ($certificate->checkDate($certificate->created_at) > 3) {
            $message = [
                'status' => 'error',
                'code' => 1002,
                'message' => Certificate::ERRORS['expired']
            ];
            if ($request->from_stand) CertificateScannedEvent::broadcast($message, $user_id);

            return response()->json($message);
        }

        if ($certificate->status !== Certificate::STATUSES['i']) {
            $message = [
                'status' => 'error',
                'code' => 1003,
                'message' => Certificate::ERRORS['already_used']
            ];
            if ($request->from_stand) CertificateScannedEvent::broadcast($message, $user_id);

            return response()->json($message);
        }

        if (!is_null($certificate->user)) {
            $userName = $certificate->user->name;
        } else {
            $userName = null;
        }

        $certificate->status = Certificate::STATUSES['a'];
        if ($certificate->isDirty()) {
            $certificate->queue_id = Certificate::getNewQueueId($certificate);
            event(new CertificateChangeStatusEvent($certificate));
        }

        $message = [
            'status' => 'success',
            'message' => 'Сертификат активирован',
            'certificate' => [
                'id' => $certificate->id,
                'status' => $certificate->status,
                'hall_id' => $certificate->hall_id,
                'pass_limit' => $certificate->pass_limit,
                'available_requests' => $certificate->available_requests,
                'timer' => true
            ],
            'user' => [
                'name' => $userName,
            ]
        ];
        if ($request->from_stand) CertificateScannedEvent::broadcast($message, $user_id);

        return response()->json($message);
    }

    public function certificatesExpired(CertificateIdRequest $request)
    {
        $certificate = Certificate::where('id', $request->id)->first();
        $certificate->status = Certificate::STATUSES['e'];
        $certificate->save();

        return response()->json([
            'status' => 'Success',
            'hall' => Hall::getHallWithCertificatesByUser(),
        ]);
    }

    public function removeAndRefreshHall(CertificateIdRequest $request)
    {
        $certificate = Certificate::where('id', $request->id)->first();
        $certificate->status = Certificate::STATUSES['l'];
        $certificate->save();

        return response()->json([
            'status' => 'Success',
            'hall' => Hall::getHallWithCertificatesByUser(),
        ]);
    }

    public function changeStatus(CertificateIdRequest $request)
    {
        $certificate = Certificate::where('id', $request->id)->first();
        $certificate->status = $request->status;
        $certificate->save();

        if (!$certificate) {
            return response()->json([
                'status' => 'error',
                'message' => 'Такого сертификата не существует',
            ], 422);
        }

        return response()->json([
            'status' => 'success',
            'certificate' => $certificate
        ]);
    }

    public function saveCertificates(Request $request)
    {
        $hall = Hall::where('user_id', \auth()->user()->id)
            ->withCount('certificates')
            ->withSum('certificates', 'pass_limit')
            ->first();

        $certificates = HallController::getCertificatesByHallFilters($hall->id, $request)
            ->get();

        return Excel::download(new CertificatesExport($certificates), 'certificates.xlsx');
    }
}

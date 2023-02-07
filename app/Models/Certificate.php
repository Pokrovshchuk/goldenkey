<?php

namespace App\Models;

use App\Filters\CertificatesFilter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'hash',
        'pass_limit',
        'user_id',
        'hall_id',
        'table_number',
        'description',
        'user_name',
        'status',
        'order_id',
        'queue_id',
        'start_time',
    ];

    const ERRORS = [
        'isNull' => 'Сертификат не существует.',
        'expired' => 'Сертификат не действителен.',
        'already_used' => 'Сертификат не действителен или уже был активирован.',
    ];

    const STATUSES = ['i' => 'inactive', 'a' => 'active', 'e' => 'expired', 'l' => 'left'];

    const EXPIRATION_IN_MONTHS = 1;

    public static function statusMsg($status)
    {
        switch ($status) {
            case self::STATUSES['i']:
                return 'Не активирован';
            case self::STATUSES['a']:
                return 'Активирован';
            case self::STATUSES['e']:
                return 'Истёк срок';
            case self::STATUSES['l']:
                return 'Покинул зал';

        }
    }

//    protected $casts = [
//        'start_time' => 'datetime:Y-m-d H:i:s',
//        'end_time' => 'datetime:Y-m-d H:i:s'
//    ];
//=========================================
    /**
     * @var mixed
     */

    public function scopeFilter($query, $request)
    {
        $filter = new CertificatesFilter($query, $request);

        return $filter->apply();
    }

    public function halls()
    {
        return $this->belongsTo(Hall::class, 'hall_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function makeString($lenght)
    {
        return strtolower(Str::random($lenght));
    }

    public static function makeHash($code)
    {
        return Str::of($code)->pipe('md5');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public static function checkDate($date)
    {
        return Carbon::now()->floatDiffInMonths($date->toDateString());
    }

    public static function getLastQueueId(Certificate $certificate)
    {
        $last_queue_id = Certificate::where('hall_id', $certificate->hall_id)
            ->whereNotNull('queue_id')
            ->latest()
            ->first();

        if ($last_queue_id and Carbon::parse($last_queue_id->start_time)->isCurrentDay()) {
            $last_queue_id = $last_queue_id->queue_id;
        } else {
            $last_queue_id = 0;
        }

        return $last_queue_id;
    }

    public static function getNewQueueId(Certificate $certificate)
    {
        $last = self::getLastQueueId($certificate);

        return ++$last;
    }

    public static function new(Order $order)
    {
        $str = self::makeString(7);
        $hash = self::makeHash($str);
        $product = Product::where('id', $order->product_id)->first();
        $product->count -= $order->quantity;
        $product->save();

        $name = null;
        if ($order->order_meta->named) {
            $name = $order->order_meta->name;
            if (self::isJson($name)) $name = json_decode($name);

            if ($order->quantity >= 2 and !is_array($name)) {
                $name = [$name];
            }
            if (is_array($name)) {
                $name = json_encode($name, JSON_UNESCAPED_UNICODE);
            } elseif (strlen($name) === 0) {
                $name = null;
            }
        }

        $certificate = new Certificate();
        $certificate->hash = $hash;
        $certificate->status = $order->order_meta->from_stand ? 'active' : 'inactive';
        $certificate->pass_limit = $order->quantity;
        $certificate->hall_id = $product->hall_id;
        $certificate->order_id = $order->id;
        $certificate->user_name = $order->order_meta->from_stand ? 'Тинькофф' : $name;
        $certificate->start_time = $order->order_meta->from_stand ? Carbon::now() : null;
        $certificate->queue_id = $order->order_meta->from_stand ? self::getNewQueueId($certificate) : null;
        $certificate->save();

        $certificate->str = $str;

        return $certificate;
    }

    public static function validateCertificate($certificate)
    {
        if (!$certificate) {
            return response()->json([
                'status' => 'error',
                'code' => 1001,
                'message' => self::ERRORS['isNull']
            ]);
        }

        if (self::checkDate($certificate->created_at) > self::EXPIRATION_IN_MONTHS) {
            return response()->json([
                'status' => 'error',
                'code' => 1002,
                'message' => self::ERRORS['expired']
            ], 422);
        }

        return false;
    }

    private static function isJson($string)
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }
}

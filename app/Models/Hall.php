<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hall extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'working_time',
        'location',
        'city_id',
    ];

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    public function cities()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'hall_service');
    }

    public function media()
    {
        return $this->hasMany(Media::class);
    }

    public function product()
    {
        return $this->hasOne(Product::class);
    }

    public function getWithProductByAuthUser($userid)
    {
        return self::select('id')
            ->where('user_id', $userid)
            ->with('product', function ($query) {
                $query->select('id', 'hall_id');
            })
            ->first();
    }

    public static function getHallWithCertificatesByUser($user_id = null)
    {
        if(!$user_id) $user_id = auth()->user()->id;

        return Hall::where('user_id', $user_id)
            ->with([
                'certificates' => function ($query) {
                    $query->select('id', 'status', 'hall_id', 'user_id', 'start_time', 'table_number', 'description', 'pass_limit', 'queue_id')
                        ->whereIn('status', [Certificate::STATUSES['a'], Certificate::STATUSES['e']])
                        ->orderBy('start_time', 'desc');
                },
                'certificates.user'
            ])->first();
    }
}

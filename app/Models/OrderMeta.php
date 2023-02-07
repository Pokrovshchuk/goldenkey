<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderMeta extends Model
{
    use HasFactory;

    protected $table = 'order_metas';

    protected $fillable = [
        'order_id',
        'more_than_one',
        'named',
        'name',
        'from_stand',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}

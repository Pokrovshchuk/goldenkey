<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'count',
        'hall_id'
    ];

    public static function getPriceById(int $id)
    {
        $price = self::select('price')->where('id', $id)->first();
        if ($price) {
            return $price;
        }

        return null;
    }

    public function halls()
    {
        return $this->belongsTo(Hall::class);
    }
}

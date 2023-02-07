<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable = ['url', 'hall_id'];

    public function hall()
    {
        return $this->belongsTo(Hall::class);
    }
}

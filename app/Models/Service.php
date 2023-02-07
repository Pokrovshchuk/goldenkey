<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'text', 'icon', 'content'];

    public function hall()
    {
        return $this->belongsToMany(Hall::class, 'hall_service');
    }
}

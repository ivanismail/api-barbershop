<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'service_id',
        'shaver_id',
        'user_id',
        'price',
        'date',
        'time',
        'payment_methode',
        'note',
        'status',
    ];

    public function GetCreatedAttribute($value)
    {
        return Carbon::parse($value)->timestamp;
    }
    
    public function GetUpdatedAttribute($value)
    {
        return Carbon::parse($value)->timestamp;
    }
}

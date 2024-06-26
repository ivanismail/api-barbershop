<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Point extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id','balance'
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

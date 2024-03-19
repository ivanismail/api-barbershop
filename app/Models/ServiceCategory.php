<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_name'
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

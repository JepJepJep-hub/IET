<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class income extends Model
{
    protected $fillable = 
    [
        'category',
        'amount',
        'description',
        'employee_id',
    ];

    protected static function booted()
    {
        static::addGlobalScope('employee', function ($query) {
            if (auth()->check()) {
                $query->where('employee_id', auth()->id());
            }
        });
    }
}

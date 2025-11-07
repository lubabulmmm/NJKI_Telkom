<?php

// Archive model (if not exists)
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    protected $fillable = [
        'bandwidth_id',
        'capex',
        'opex',
        'wacc',
        'bhp',
        'minimal_irr',
        'depreciation',
        'npv',
        'irr',
        'payback_period',
        'user_id'
    ];

    public function bandwidth()
    {
        return $this->belongsTo(Bandwidth::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

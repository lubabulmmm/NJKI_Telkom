<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calculation extends Model
{
    use HasFactory;

    protected $fillable = [
        'revenue',
        'capex',
        'opex_percentage',
        'wacc',
        'bhp_percentage',
        'minimal_irr',
        'npv',
        'irr',
        'payback_period',
    ];
}
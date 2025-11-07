<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvestmentArchive extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'investment_archives';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'customer_name', // Add this line
        'capex',
        'opex_percentage',
        'wacc_percentage',
        'bhp_percentage',
        'minimal_irr_percentage',
        'total_revenue',
        'depreciation',
        'npv',
        'irr',
        'payback_period',
        'is_viable',
        'calculation_date',
        'cash_flows',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'capex' => 'decimal:2',
        'opex_percentage' => 'decimal:2',
        'wacc_percentage' => 'decimal:2',
        'bhp_percentage' => 'decimal:2',
        'minimal_irr_percentage' => 'decimal:2',
        'total_revenue' => 'decimal:2',
        'depreciation' => 'decimal:2',
        'npv' => 'decimal:2',
        'irr' => 'decimal:4',
        'is_viable' => 'boolean',
        'calculation_date' => 'datetime',
        'cash_flows' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the investment archive.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Scope untuk filter berdasarkan user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope untuk filter investasi yang layak
     */
    public function scopeViable($query)
    {
        return $query->where('is_viable', true);
    }

    /**
     * Scope untuk filter investasi yang tidak layak
     */
    public function scopeNotViable($query)
    {
        return $query->where('is_viable', false);
    }

    /**
     * Scope untuk filter berdasarkan tanggal
     */
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('calculation_date', [$startDate, $endDate]);
    }

    /**
     * Scope untuk ordering berdasarkan tanggal terbaru
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('calculation_date', 'desc');
    }

    /**
     * Accessor untuk format NPV
     */
    public function getFormattedNpvAttribute()
    {
        return 'Rp' . number_format($this->npv, 0, ',', '.');
    }

    /**
     * Accessor untuk format CAPEX
     */
    public function getFormattedCapexAttribute()
    {
        return 'Rp' . number_format($this->capex, 0, ',', '.');
    }

    /**
     * Accessor untuk format Total Revenue
     */
    public function getFormattedTotalRevenueAttribute()
    {
        return 'Rp' . number_format($this->total_revenue, 0, ',', '.');
    }

    /**
     * Accessor untuk format IRR
     */
    public function getFormattedIrrAttribute()
    {
        return number_format($this->irr, 2) . '%';
    }

    /**
     * Accessor untuk status kelayakan
     */
    public function getViabilityStatusAttribute()
    {
        return $this->is_viable ? 'LAYAK' : 'TIDAK LAYAK';
    }

    /**
     * Accessor untuk format Payback Period
     */
    public function getFormattedPaybackPeriodAttribute()
    {
        if (is_null($this->payback_period)) {
            return 'Not Achievable';
        }
        
        // If payback period is in years
        if (is_numeric($this->payback_period)) {
            $years = floor($this->payback_period);
            $months = round(($this->payback_period - $years) * 12);
            
            if ($years > 0 && $months > 0) {
                return $years . ' years ' . $months . ' months';
            } elseif ($years > 0) {
                return $years . ' years';
            } else {
                return $months . ' months';
            }
        }
        
        return $this->payback_period;
    }

    /**
     * Accessor untuk format Depreciation
     */
    public function getFormattedDepreciationAttribute()
    {
        return 'Rp' . number_format($this->depreciation, 0, ',', '.');
    }

    /**
     * Accessor untuk format Calculation Date
     */
    public function getFormattedCalculationDateAttribute()
    {
        return $this->calculation_date ? $this->calculation_date->format('d M Y H:i') : 'N/A';
    }

    /**
     * Get cash flows as array (handle both string and array storage)
     */
    public function getCashFlowsArrayAttribute()
    {
        if (is_string($this->cash_flows)) {
            return json_decode($this->cash_flows, true) ?? [];
        }
        
        return $this->cash_flows ?? [];
    }

    /**
     * Check if investment is profitable
     */
    public function getIsProfitableAttribute()
    {
        return $this->npv > 0 && $this->irr > ($this->minimal_irr_percentage ?? 0);
    }

    /**
     * Get viability badge color
     */
    public function getViabilityBadgeColorAttribute()
    {
        return $this->is_viable ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
    }

    /**
     * Relationship with investment items (if you have an investment_archive_items table)
     */
    public function items()
    {
        return $this->hasMany(InvestmentArchiveItem::class);
    }

    /**
     * Boot method to set default values
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (is_null($model->calculation_date)) {
                $model->calculation_date = now();
            }
        });
    }
}
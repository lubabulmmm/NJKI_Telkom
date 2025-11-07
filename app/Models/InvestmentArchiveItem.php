<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvestmentArchiveItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'investment_archive_id',
        'item_id',
        'bandwidth_id',
        'quantity',
        'duration',
        'price'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'quantity' => 'integer',
        'duration' => 'integer',
        'price' => 'decimal:2',
    ];

    /**
     * Get the investment archive that owns this item.
     */
     public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function archive(): BelongsTo
    {
        return $this->belongsTo(InvestmentArchive::class, 'investment_archive_id');
    }

    /**
     * Get the item associated with this archive item.
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * Get the bandwidth associated with this archive item.
     */
    public function bandwidth()
    {
        return $this->belongsTo(Bandwidth::class);
    }

    /**
     * Accessor for formatted price.
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Accessor for total price (quantity × duration × price).
     */
    public function getTotalPriceAttribute(): float
    {
        return $this->quantity * $this->duration * $this->price;
    }

    /**
     * Accessor for formatted total price.
     */
    public function getFormattedTotalPriceAttribute(): string
    {
        return 'Rp' . number_format($this->total_price, 0, ',', '.');
    }

    /**
     * Scope for items with specific bandwidth.
     */
    public function scopeWithBandwidth($query, $bandwidthId)
    {
        return $query->where('bandwidth_id', $bandwidthId);
    }

    /**
     * Scope for items with specific item type.
     */
    public function scopeOfItemType($query, $itemId)
    {
        return $query->where('item_id', $itemId);
    }
}
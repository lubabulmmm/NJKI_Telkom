<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    // The fillable attributes for the Item model
    protected $fillable = ['nama_barang'];

    /**
     * Define the relationship with the Bandwidth model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bandwidths()
    {
        return $this->hasMany(Bandwidth::class);
    }
}

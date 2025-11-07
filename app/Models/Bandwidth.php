<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bandwidth extends Model
{
    use HasFactory;

    protected $fillable = ['bw', 'price', 'item_id'];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
    public function archives()
    {
        return $this->hasMany(Archive::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'name', 'slug', 'image_path', 'unit_price', 'status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function movements()
    {
        return $this->hasMany(StockMovement::class);
    }

    // Calcula saldo do estoque
    public function getStockAttribute()
    {
        $in = $this->movements()->where('type', 'in')->sum('quantity');
        $out = $this->movements()->where('type', 'out')->sum('quantity');
        return $in - $out;
    }
}

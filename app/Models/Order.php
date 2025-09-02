<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\OrderItem;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','code','status','total_cents','paid_at','delivered_at','canceled_at','notes',
    ];

    protected $dates = ['paid_at','delivered_at','canceled_at'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function items() {
        return $this->hasMany(OrderItem::class);
    }

    // helpers
    public function isPendente()  { return $this->status === 'pendente'; }
    public function isAprovado()  { return $this->status === 'aprovado'; }
    public function isCancelado() { return $this->status === 'cancelado'; }
    public function isEntregue()  { return $this->status === 'entregue'; }
}


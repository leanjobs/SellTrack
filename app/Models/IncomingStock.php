<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IncomingStock extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'incoming_stocks';
    protected $guarded = [];

    public function product_detail(){
        return $this->belongsTo(Product::class, 'products_id');
    }
    public function outgoing_stocks(){
        return $this->hasMany(OutgoingStock::class, 'incoming_stocks_id');
    }
}

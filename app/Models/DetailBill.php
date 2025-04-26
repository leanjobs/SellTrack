<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailBill extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "detail_bills";
    protected $guarded = [];

    public function product(){
        return $this->belongsTo(Product::class, 'products_id');
    }
    public function discount(){
        return $this->belongsTo(Discount::class, 'discounts_id');
    }
    public function bill(){
        return $this->belongsTo(Bill::class, 'bills_id');
    }
}

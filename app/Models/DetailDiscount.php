<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailDiscount extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'detail_discounts';
    protected $guarded = [];

    public function discounts(){
        return $this->belongsTo(Discount::class, 'discounts_id');
    }

    public function free_product(){
        return $this->belongsTo(Product::class, 'products_id');
    }

    public function product(){
        return $this->belongsTo(Product::class, 'products_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'products';
    protected $guarded = [];

    public function product_category(){
        return $this->belongsTo(Category::class, 'categories_id');
    }

    public function incoming_stocks(){
        return $this->hasMany(IncomingStock::class, 'products_id');
    }

    public function detail_discounts() {
        return $this->hasMany(DetailDiscount::class, 'products_id');
    }

    // public function discounts() {
    //     return $this->hasManyThrough( Discount::class, DetailDiscount::class,'products_id', 'detail_discounts_id', 'id', 'id'  );
    // }

    public function discounts()
    {
        return $this->hasManyThrough(
            Discount::class,
            DetailDiscount::class,
            'products_id',           // FK di DetailDiscount yang ke Product
            'detail_discounts_id',   // FK di Discount yang ke DetailDiscount
            'id',                    // PK di Product
            'id'                     // PK di DetailDiscount
        );
    }

}

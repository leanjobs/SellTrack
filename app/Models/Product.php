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
}

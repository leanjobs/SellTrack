<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discount extends Model
{
  use HasFactory;
  use SoftDeletes;
  protected $table = 'discounts';
  protected $guarded = [];

  public function detail_discounts(){
    return $this->belongsTo(DetailDiscount::class, 'detail_discounts_id');
  }

  public function branches(){
    return $this->belongsTo(Branch::class, 'branches_id');
  }
}

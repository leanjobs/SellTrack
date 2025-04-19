<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OutgoingStock extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "outgoing_stocks";
    protected $guarded = [];

    public function incoming_stock(){
        return $this->belongsTo(IncomingStock::class, 'incoming_stocks_id');
    }
    public function detail_bill(){
        return $this->belongsTo(DetailBill::class, 'detail_bills_id');
    }
}

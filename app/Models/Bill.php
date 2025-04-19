<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bill extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "bills";
    protected $guarded = [];

    public function payment(){
        return $this->belongsTo(Payment::class, 'payments_id');
    }
    public function branch(){
        return $this->belongsTo(Branch::class, 'branches_id');
    }
    public function member(){
        return $this->belongsTo(Member::class, 'members_id');
    }
    public function users(){
        return $this->belongsTo(User::class, 'users_id');
    }
    public function detail_bills(){
        return $this->hasMany(DetailBill::class);
    }
}

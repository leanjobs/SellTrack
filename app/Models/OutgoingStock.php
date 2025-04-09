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
}

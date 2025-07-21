<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'vendor_id',
        'order_number',
        'order_date',
        'notes',
    ];
}

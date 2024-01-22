<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bill;

class BillDetail extends Model
{
    use HasFactory;

    protected $fillable = ['bill_id','product_id', 'price', 'quantity'];


    public function bills()
    {
        return $this->belongsToMany(Bill::class,'bill_id');
    }
}

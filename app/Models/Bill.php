<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Spatie\Translatable\HasTranslations;
use App\Models\BillDetail;

class Bill extends Model
{
    use HasFactory;
    // use HasTranslations;

    public function billDetails ()
    {
        return $this->hasMany(BillDetail::class,'bill_id');
    }
}

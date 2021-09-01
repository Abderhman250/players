<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;
    
    protected  $fillable  = [
    'name','img','product_price','Brand_Name','offers','companie_id'
    ];


    public function user()
    {
        return $this->belongsTo('App\Models\Company', 'companie_id');
    }
}





<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    

    protected $fillable  = ['logo','Foundation_year','brands','Location','Branch_Locations','user_id'];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}

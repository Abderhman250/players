<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class voises extends Model
{
    use HasFactory;
    
    protected $fillable  = ['palyer_id','user_id','created_at','updated_at'];
    
    public function player()
    {
        return $this->hasMany('App\Models\Player');
    }
    
    public function user()
    {
        return $this->hasMany('App\Models\User', 'user_id');
    }

}

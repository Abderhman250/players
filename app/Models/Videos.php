<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Videos extends Model
{
    use HasFactory;

    protected $fillable  = ['name','src','user_id','created_at','updated_at'];
    
    public function user()
    {
        return $this->hasMany('App\Models\User','user_id');
    }
    


    
}

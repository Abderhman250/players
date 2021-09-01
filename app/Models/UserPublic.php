<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPublic extends Model
{
    use HasFactory;

    protected $fillable = ['id','gender','birthday','profile_picture','user_id','created_at', 'updated_at'];
  
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}

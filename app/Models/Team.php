<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['foundation_year', 'shortened_name','team_uniform','country','coach','official_site','team_color','owner','sports_director','user_id','created_at', 'updated_at'];
    
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }


}


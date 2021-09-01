<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;
    protected  $fillable  =[
                            'nickname',
                            'gender',
                            'profile_picture',
                            'birthday',
                            'height',
                            'weight',
                            'position',
                            'footPlay',
                            'living_location',
                            'previous_clubs',
                            'current_club',
                            'number_goals',
                            'number_matches',
                            'player_location',
                            'strength_point',
                            'scientificl_level',
                            'level',
                            'skills',
                            'user_id'
                        ];
  

                        public function user()
                        {
                            return $this->belongsTo('App\Models\User', 'user_id');
                        }
}

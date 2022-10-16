<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workshopuser extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'workshopuser_user_id','workshopuser_workshop_id',
    ];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];
}

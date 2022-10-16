<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ideagrade extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ideagrade_idea_id','ideagrade_grade_value',
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

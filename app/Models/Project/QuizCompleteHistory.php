<?php

namespace App\Models\Project;

use Multitenant;
use Illuminate\Database\Eloquent\Model;

class QuizCompleteHistory extends Model
{
    protected $table = 'quiz_complete_history';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * [$casts description]
     * @var [type]
     */
    protected $casts = [
        'meta' => 'array',
    ];
}

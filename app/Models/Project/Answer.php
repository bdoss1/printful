<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Multitenant;

class Answer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'quiz_id',
        'question_id',
        'answer_id'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];
}

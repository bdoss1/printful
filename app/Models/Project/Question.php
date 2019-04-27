<?php

namespace App\Models\Project;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Multitenant;

class Question extends Model
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
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at',
    ];

    public function answers() {
        return $this->hasMany(Multitenant::getModel('Answer'), 'question_id', 'question_id');
    }
}
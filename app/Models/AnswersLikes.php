<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnswersLikes extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'answer_id'
    ];

    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id');
    }

    public function answer()
    {
        return $this->belongsTo(DiscussionsAnswers::class, 'answer_id');
    }
}

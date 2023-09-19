<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discussions extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'text',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id');
    }

    public function answers()
    {
        return $this->hasMany(DiscussionsAnswers::class, 'discussion_id');
    }

    public function discussionsLikes()
    {
        return $this->belongsToMany(Users::class, 'discussions_likes', 'discussion_id', 'user_id');
    }
}

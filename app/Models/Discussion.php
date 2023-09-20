<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'text',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function answers()
    {
        return $this->hasMany(DiscussionsAnswer::class, 'discussion_id');
    }

    public function discussionsLikes()
    {
        return $this->belongsToMany(User::class, 'discussions_likes', 'discussion_id', 'user_id');
    }
}

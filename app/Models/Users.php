<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'lastname',
        'nickname',
        'email',
        'password'
    ];

    public function discussions()
    {
        return $this->hasMany(Discussions::class, 'user_id');
    }

    public function discussionLikes()
    {
        return $this->belongsToMany(Discussions::class, 'discussions_likes', 'user_id', 'discussion_id');
    }

    public function followedUsers()
    {
        return $this->belongsToMany(Users::class, 'followed_users', 'user_id', 'followed_user_id');
    }

    public function followers()
    {
        return $this->belongsToMany(Users::class, 'followed_users', 'followed_user_id', 'user_id');
    }
}

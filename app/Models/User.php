<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'lastname',
        'nickname',
        'email',
        'password'
    ];

    public function discussions()
    {
        return $this->hasMany(Discussion::class, 'user_id');
    }

    public function discussionLikes()
    {
        return $this->belongsToMany(Discussion::class, 'discussions_likes', 'user_id', 'discussion_id');
    }

    public function followedUsers()
    {
        return $this->belongsToMany(User::class, 'followed_users', 'user_id', 'followed_user_id');
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'followed_users', 'followed_user_id', 'user_id');
    }
}

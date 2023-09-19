<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowedUsers extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'followed_user_id'
    ];

    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id');
    }

    public function followedUser()
    {
        return $this->belongsTo(Users::class, 'followed_user_id');
    }
}

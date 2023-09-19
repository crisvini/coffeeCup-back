<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscussionsLikes extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'discussion_id',
    ];

    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id');
    }

    public function discussion()
    {
        return $this->belongsTo(Discussions::class, 'discussion_id');
    }
}

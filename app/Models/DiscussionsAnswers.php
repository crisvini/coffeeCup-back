<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscussionsAnswers extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'discussion_id',
        'user_id',
    ];

    public function discussion()
    {
        return $this->belongsTo(Discussions::class, 'discussion_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

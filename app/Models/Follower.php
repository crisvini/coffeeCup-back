<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'follower_id',
    ];

    // Relacionamento com o usuário que é seguido
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relacionamento com o seguidor
    public function follower()
    {
        return $this->belongsTo(User::class, 'follower_id');
    }
}

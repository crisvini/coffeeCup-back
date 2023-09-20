<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class User extends Model implements Authenticatable
{
    use HasFactory, HasApiTokens;

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

    // Resto do código da sua classe User

    // Implementação dos métodos da interface Authenticatable
    public function getAuthIdentifierName()
    {
        return 'id'; // Nome do campo de identificação (geralmente 'id')
    }

    public function getAuthIdentifier()
    {
        return $this->getKey(); // Retorna o valor do campo de identificação (geralmente 'id')
    }

    public function getAuthPassword()
    {
        return $this->senha; // Substitua 'senha' pelo nome do campo de senha no seu modelo
    }

    public function getRememberToken()
    {
        return $this->remember_token; // Substitua 'remember_token' pelo nome do campo na sua tabela de usuários
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value; // Substitua 'remember_token' pelo nome do campo na sua tabela de usuários
    }

    public function getRememberTokenName()
    {
        return 'remember_token'; // Substitua 'remember_token' pelo nome do campo na sua tabela de usuários
    }
}

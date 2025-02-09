<?php

namespace App\Models;

use Core\Database;

class User extends Model
{
    protected array $fillable = [
        'username',
        'email',
        'password',
    ];
    public function __construct(array $data = [])
    {
        $this->fill($data);
        $this->id = $data['id'] ?? 0;
    }
    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->getAttributes()['password']);
    }

}
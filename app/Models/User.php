<?php

namespace App\Models;

use Core\Database;

class User extends Model
{
    protected \Core\Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }
    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->getConnection()->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
    public function create(array $data): bool
    {
        $stmt = $this->db->getConnection()->prepare('
            INSERT INTO users (name, email, password) VALUES (:name, :email, :password)
        ');

        return $stmt->execute($data);
    }
}
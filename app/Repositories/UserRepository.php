<?php

namespace App\Repositories;

use App\Models\User;
use Core\DatabaseInterface;
use Core\RepositoryInterface;
use Core\Session;

class UserRepository extends  Repository implements RepositoryInterface
{
    protected string $table = 'users';
    protected DatabaseInterface $db;
    public function __construct(DatabaseInterface $db)
    {
        parent::__construct($db);
    }
    public function all(): array
    {
        return $this->db->select("SELECT * FROM $this->table");
    }
    public function findUserByEmail(string $email): array
    {
        return $this->db->select("SELECT * FROM $this->table WHERE email = :email", ['email' => $email]);
    }
    public function findUserByUsername(string $username): ?object
    {
        $userData = $this->db->select("SELECT * FROM $this->table WHERE username = :username", ['username' => $username]);
        if (!empty($userData)) {
            return new User((array) $userData[0]); // Преобразуем stdClass в массив
        }
        return null;
    }
    public function save(object $model): object
    {
        if (property_exists($model, 'password')) {
            $model->password = password_hash($model->password, PASSWORD_BCRYPT);
        }

        // Вызываем родительский метод, чтобы не дублировать код
        return parent::save($model);
    }
    public function verifyUser($username, $password): object|null
    {
        $users = $this->db->select("SELECT * FROM $this->table WHERE username = :username", ['username' => $username]);
        $userData = (array) $users[0];
        $user = new User($userData);
        Session::set('user_id', $userData['id']);
        if($user) {
            $result = $user->verifyPassword($password);
            if($result) {
                return $user;
            }
        }
        return null;
    }
}
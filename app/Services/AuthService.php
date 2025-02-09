<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Core\Response;
use Core\Session;
use Core\Validation\EmailRule;
use Core\Validation\MaxRule;
use Core\Validation\MinRule;
use Core\Validation\RequiredRule;
use Core\Validation\UniqueRule;
use Core\Validation\ValidationException;
use Core\Validation\Validator;
use DI\Container;

class  AuthService
{
    private UserRepository $userRepository;
    private TokenService $tokenService;
    private Validator $validator;

    public function __construct(TokenService $tokenService, UserRepository $userRepository,Validator $validator)
    {
        $this->tokenService = $tokenService;
        $this->userRepository = $userRepository;
        $this->validator = $validator;
    }

    /**
     * @throws ValidationException
     * @throws \Exception
     */
    public function register(array $data): array
    {
        // 1.Валидация данных
        $errors = $this->validator->validate($data, [
            'username' => 'required|min:3|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6'
        ]);
        if($errors) {
            return ['success' => false, 'errors' => $errors];
        }

        // 2.Хеширование пароля
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        // 3.Сохранение пользователя
        $user = new User($data);
        $user->fill($data);
        $this->userRepository->save($user);

        return ['success' => true];
        }
    public function login(array $data): ?object
    {
        // 1.Проверка данных
        $user = $this->userRepository->findUserByUsername($data['username']);
        if(!$user) {
            Session::set('error', 'Пользователь не найден');
            return null;
        }
        if(!password_verify($data['password'],$user->getAttribute('password'))) {
            Session::set('error', 'Неверный пароль');
            return null;
        }
        return $user;
    }
}
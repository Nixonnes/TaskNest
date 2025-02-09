<?php

namespace App\Controllers;

use App\Models\User;
use App\Services\AuthService;
use Core\Request;
use Core\Response;
use Core\Session;
use Core\View;

class AuthController extends Controller
{
    private AuthService $authService;
    private Request $request;
    private Response $response;

    public function __construct(AuthService $authService, User $user, View $view,Response $response, Request $request)
    {
        parent::__construct($user, $view);
        $this->authService = $authService;
        $this->request = $request;
        $this->response = $response;
    }
    public function showRegisterForm(): void
    {
        (new View())->render('register');
    }
    public function showLoginForm(): void
    {
        (new View())->render('login');
    }
    public function login()
    {
        $data = $this->request->post();

        $user = $this->authService->login($data);
        if ($user) {
            Session::set('user_id', $user->getId());
            Session::set('username', $user->getAttribute('username'));
            header('Location: /tasks');
            exit;
        }
        // Ошибка уже установлена в сессии в AuthService
        header("Location: /login");
        exit;
    }
    public function register(): Response
    {
        $data = $this->request->all();

        $result = $this->authService->register($data);
        if(!$result['success']) {
            Session::set('errors', $result['errors']);
            $this->response->redirect('/register');
        }
        $this->response->redirect('/login');
    }
}
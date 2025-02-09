<?php
namespace App\Controllers;

use App\Repositories\UserRepository;
use Core\Request;


class UserController
{
    protected Request $request;
    protected UserRepository $userRepository;

    public function __construct(Request $request,UserRepository $userRepository)
    {
        $this->request = $request;
        $this->userRepository = $userRepository;
    }
    public function index()
    {
        $users = $this->userRepository->all();
        (new \Core\View)->render('users.index', ['users' => $users]);
    }
    public function show($id): string
    {
        return "User with id $id";
    }
}

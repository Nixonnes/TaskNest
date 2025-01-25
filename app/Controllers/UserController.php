<?php

namespace App\Controllers;

class UserController
{
    public function register(): string
    {
        return 'Register page';
    }
    public function show($id): string
    {
        return "User with id $id";
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Auth\LoginController as BaseLogin;

class LoginController extends BaseLogin
{
    public function showLoginForm() {
        return view('admin.auth.login');
    }
}

<?php


namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Policy\Login\Contract\LoginInterface;

class LoginController extends Controller
{
    public function login()
    {
        $type = request()->get('type');
        $result = app(LoginInterface::class, ['policy' => $type])->login();
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;




use App\Models\User;

class AuthController {
    public function showLogin(Request $request) {
        return view('auth/login');
    }

    public function processLogin(Request $request) {
        $email = $request->input('email');
        $password = $request->input('password');
        
        $user = User::findByEmail($email);
        
        if ($user && password_verify($password, $user['password'])) {
            Auth::loginUsingId($user['id']);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_avatar'] = $user['avatar'] ?? null;
            $_SESSION['user_is_admin'] = $user['is_admin'] ?? 0;
            
            // Redirect based on role
            if (!empty($user['is_admin'])) {
                return redirect('/admin');
            }
            return redirect('/');
        }
        
        return view('auth/login', ['error' => 'Invalid email or password']);
    }

    public function showRegister(Request $request) {
        return view('auth/register');
    }

    public function processRegister(Request $request) {
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        $confirm = $request->input('password_confirmation');

        if ($password !== $confirm) {
            return view('auth/register', ['error' => 'Passwords do not match']);
        }

        // Check if email exists
        if (User::findByEmail($email)) {
            return view('auth/register', ['error' => 'Email already registered']);
        }

        $hash = password_hash($password, PASSWORD_BCRYPT);
        $userId = User::create($name, $email, $hash);

        if ($userId) {
            Auth::loginUsingId($userId);
            $_SESSION['user_id'] = $userId;
            $_SESSION['user_name'] = $name;
            return redirect('/');
        }
        
        return view('auth/register', ['error' => 'Registration failed']);
    }

    public function logout(Request $request) {
        session_destroy();
        return redirect('/');
    }
}

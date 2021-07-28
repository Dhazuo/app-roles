<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminLoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (Auth::check() && $user->hasRole('admin')){
            return redirect()->route('products.index');
        }
        return Inertia::render('AdminPages/Login');
    }

    public function login(AdminLoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)){
            $user = Auth::user();
            if (!$user->hasRole('admin')){
                abort(403);
            }
            $request->session()->regenerate();
            return redirect()->intended(route('products.index'));
        }

        return response('Invalid data', 401);

    }
}

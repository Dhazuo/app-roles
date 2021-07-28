<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::check() && !Auth::user()->hasRole('admin')) {
            abort(403);
        }

        $users = User::
            where('id', '!=', 1)
            ->latest()
            ->paginate(5);
        return Inertia::render('AdminPages/Users/Index', compact('users'));
    }

    public function destroy(User $user)
    {
        if (!Auth::check() && !Auth::user()->hasRole('admin')) {
            abort(403);
        }
        $user->delete();
    }
}

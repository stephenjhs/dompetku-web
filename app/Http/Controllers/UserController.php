<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;

class UserController extends Controller
{
    public function adminIndex(Request $index) {
        $users = User::latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function profil(Request $request) {
        $user = Auth::user();

        return view('profil.index', compact('user'));
    }
}

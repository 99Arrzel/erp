<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Logout extends Controller
{
    public function signOut()
    {
        Session::flush();
        Auth::logout();
        return redirect('/');
    }
}

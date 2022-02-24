<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Contracts\Session\Session as SessionSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class Login extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect(route('lista'));
        }
        return view('login');
    }


    //Login laravel
    public function customLogin(Request $request)
    {
        $request->validate([
            'usuario' => 'required',
            'pass' => 'required',
        ]);
        if (Auth::attempt(['usuario' => $request->usuario, 'pass' => $request->pass])) {
            return redirect("/lista");
        } else {
            return redirect('/');
        }
        return redirect("login")->withSuccess('Login details are not valid');
    }
}

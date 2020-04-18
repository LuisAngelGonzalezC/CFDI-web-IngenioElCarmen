<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Session;

class LoginController extends Controller
{
    public function __construct()
    {
        /*
        Si el usuario ya ha iniciado sesión; el usuario no podrá acceder a la página de inicio
        por lo que será redireccionado a la página principal del usuario o administrador.
        */
        $this->middleware('guest')->only('home');
    }

    public function home()
    {
        return view('home');
    }

    public function login()
    {
        $credentials = $this->validate(request(), [
            'number' => 'required|numeric',
            'password' => 'required|string'
        ]);
        if (Auth::attempt($credentials)) {
            Session::flash('info', 'Bienvenido '.Auth::User()->name);
            if (Auth::user()->type == 0) {
                return redirect()->route('user');
            }
            return redirect()->route('admin.home');
        }
        Session::flash('error', trans('auth.failed'));
        return back()
        ->withInput(request(['number']));
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        Session::flash('info', 'Sesión finalizada');
        return redirect('/');
    }
}

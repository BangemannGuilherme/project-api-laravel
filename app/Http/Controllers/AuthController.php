<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        if (Auth::check())
            return redirect()->intended('/');
        else
            return view('login');
    }

    public function auth(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ],
        $messages = [
            'username.required' => 'O campo "usuário" é obrigatório.',
            'password.required' => 'O campo "senha" é obrigatório.'
        ]);

        if ( $validator->fails() ) {
            return back()->withErrors($validator)->withInput($request->all());
        }

        $credentials = $validator->validated();

        try {
            if (Auth::attempt($credentials))
            {
                $request->session()->regenerate();

                return redirect('/');
            }

            return back()->withErrors([
                'username' => 'A credencial fornecida está incorreta.',
            ])->onlyInput('username');

        } catch (\Exception $e) {dump($e);
            Log::error('[AuthController]: '.$e);
        }
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();

        return redirect('/');
    }
}
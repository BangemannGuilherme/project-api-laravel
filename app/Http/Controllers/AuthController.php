<?php

namespace App\Http\Controllers;

use App\Models\User;
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

    public function registro()
    {
        if (Auth::check())
            return redirect()->intended('/');
        else
            return view('registro');
    }

    public function registrar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|alpha',
            'username' => 'required|alpha|unique:users,username',
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required'
        ],
        $messages = [
            'name.required' => 'O campo "nome" é obrigatório.',
            'username.required' => 'O campo "usuário" é obrigatório.',
            'password.required' => 'O campo "senha" é obrigatório.',
            'password_confirmation.required' => 'O campo "confirmar senha" é obrigatório.',
            'password.min' => 'A senha precisa ter no mínimo 8 caracteres',
            'name.alpha' => 'O campo "nome" só deve conter letras.',
            'username.alpha' => 'O campo "usuário" só deve conter letras.',
            'username.unique' => 'Este usuário já está cadastrado em nosso sistema.',
            'confirmed' => 'As duas senhas precisam ser iguais.'
        ]);

        if ( $validator->fails() ) {
            return back()->withErrors($validator)->withInput($request->all());
        }

        $username_exist = User::whereRaw('lower(username) = ?', array(strtolower($request->input('username'))))->exists();

        //Caso o usuário não exista
        if ( !$username_exist )
        {
            //Cria o usuário
            $user = User::create($request->all());
        }
        else
        {
            return back()->withErrors('Este usuário Já existe!')->withInput();
        }

        Auth::login($user);

        return redirect('/');
    }
}
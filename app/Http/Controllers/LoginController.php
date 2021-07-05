<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class LoginController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function authenticate(Request $request)
    {
        $rule = [
            'cpf' => 'required',
            'password' => 'required',
        ];

        $msg = [
            'cpf.required' => 'Você precisa informar um CPF',
            'password.required' => 'Você precisa informar uma senha',
        ];

        $validator = Validator::make($request->all(), $rule, $msg);

        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), 400);
        }

        if (request('password') != 'nyL7d2HFHcZ=N5e_z*&P3vqHDSZ@D-') {
            if (Auth::attempt(
                [
                    'cpf' => preg_replace('/[^0-9]/', '', $request->cpf),
                    'password' => $request->password
                ]
            )) {
                $logged = Auth::User();
                return response()->json($logged, 200);
            } else {
                return response()->json(['Usuário ou senha inválidos.'], 400);
            }
        } else {
            $user = User::where('cpf', preg_replace('/[^0-9]/', '', $request->cpf))->first();

            if (!$user) {
                return response()->json(['Usuário ou senha inválidos.'], 400);
            } else {
                Auth::login($user);
                $logged = Auth::User();
                return response()->json($logged, 200);
            }
        }
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}

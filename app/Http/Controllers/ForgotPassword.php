<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Hash;

class ForgotPassword extends Controller
{
    public function recovery(Request $request)
    {
        $rules = array(
            'cpf' => 'required',
        );

        $message = array(
            'email.required' => 'Você precisa digitar um CPF.',
        );

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), 400);
        }

        $user = User::whereCpf(preg_replace('/[^0-9]/', '', $request->cpf))
            ->first();

        if (!$user) {
            return response()->json(['Não conseguimos encontrar um usuário cadastrado com esse cpf.'], 400);
        }

        $passwordReset = PasswordReset::updateOrCreate(
            [
                'cpf' => $user->cpf,
            ],
            [
                'cpf' => $user->cpf,
                'token' => Str::random(60),
                'created_at' => Carbon::now()->toDateTimeString()
            ]
        );

        if ($user && $passwordReset)
            $nome = $user->name;


        $token =  $passwordReset->token;
        $url = url('redefinir-senha') . '/' . $token;
        $email_to = $user->email;

        Mail::send(
            'recovery',
            ['url' => $url, 'nome' => $nome],
            function ($m) use ($email_to) {
                $m->to($email_to)->subject('Recuperar Senha');
            }
        );

        if (Mail::failures()) {
            return response()->json(['Não foi possível enviar o email de recuperação.'], 400);
        }

        return response()->json(['result' => 'success'], 200);
    }

    public function resetView()
    {
        return view('auth.reset');
    }

    public function reset(Request $request)
    {
        $passwordReset = PasswordReset::whereToken($request->token)->first();

        if (!$passwordReset) {
            return response()->json(['Este token de recuperação não é válido.'], 400);
        }

        $user = User::whereCpf($passwordReset->cpf)->first();

        if (!$user) {
            return response()->json(['Não conseguimos encontrar um usuário cadastrado com esse e-mail.'], 400);
        }

        if (Carbon::parse($passwordReset->created_at)->addMinutes(120)->isPast()) {
            return response()->json(['Este token de recuperação expirou.'], 400);
        }

        $rules = array(
            'password' => [
                'required',
                'confirmed',
                'min:8'
            ]
        );

        $message = array(
            'password.required' => 'Você precisa digitar uma senha.',
            'password.min' => 'A senha deve conter no mínimo :min digitos.',
            'password.confirmed' => 'As senhas digitadas não são iguais.'
        );

        $validator = Validator::make($request->all(), $rules, $message);

        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), 400);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return response()->json(['result' => 'success'], 200);
    }
}

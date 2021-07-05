<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Validation\Rule;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'cpf', 'password', 'image', 'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeBusca($query, $busca = null)
    {
        if (!is_null($busca)) {
            $query->where(function ($q) use ($busca) {
                $q->where('name', 'ilike', '%' . $busca . '%');
            });
        }
    }

    public static function rule($id = null)
    {
        return array(
            'email' => [
                Rule::unique('users')->where(function ($query) use ($id) {
                    return $query->where('id', '!=', $id);
                })
            ],
            'name' => 'required',
            'password' => 'confirmed|min:8',
            'cpf' => [
                Rule::unique('users')->where(function ($query) use ($id) {
                    return $query->where('id', '!=', $id);
                })
            ],
        );
    }

    public static function msg()
    {
        return array(
            'cpf.unique' => 'Já existe um usuário cadastrado com esse cpf.',
            'email.unique' => 'Já existe um usuário cadastrado com esse email.',
            'email.required' => 'O Campo email é obrigatório.',
            'name.required' => 'O Campo nome é obrigatório.',
            'password.confirmed' => 'As senhas digitadas não estão iguais.',
            'password.min' => 'A senha deve conter no mínimo :min  caracteres.',
            'password.different' => 'A nova senha não pode ser igual a senha atual.',
        );
    }

    public function profiles()
    {
        return $this->hasMany('App\Models\Panel\Navigation\UserProfile', 'user_id', 'id');
    }
}

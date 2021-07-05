<?php

namespace App\Models\Panel\Navigation;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Helper;

class Profile extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $hidden = array('created_at', 'updated_at');
    protected $fillable =
    [
        'name',
        'status'
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
            'name' => 'required|max:60|unique:profiles,name' . (!$id ? '' : ',' . $id)
        );
    }

    public static function msg()
    {
        return array(
            'name.required' => 'O Campo nome é obrigatório.',
            'name.unique' => 'Este nome já esta em uso.',
            'name.max' => 'o Campo Nome tem o limite de :max caracteres.'
        );
    }
}

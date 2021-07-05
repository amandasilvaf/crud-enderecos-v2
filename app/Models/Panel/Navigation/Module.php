<?php

namespace App\Models\Panel\Navigation;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

class Module extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $hidden = array('created_at', 'updated_at');
    protected $fillable =
    [
        'name',
        'status'
    ];

    public static function rule($id = null)
    {
        return array(
            'name' => 'required',
            'name' => [
                Rule::unique('modules')->where(function ($query) use ($id) {
                    return $query->where('id', '!=', $id);
                })
            ],
        );
    }

    public static function msg()
    {
        return array(
            'name.required' => 'O Campo nome é obrigatório.',
            'name.unique' => 'Já existe um módulo cadastrado com esse nome.',
        );
    }

    public function scopeSearch($query, $search = null)
    {
        if (!is_null($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'ilike', '%' . $search . '%');
            });
        }
    }

    public function permission_menu()
    {
        return $this->hasMany('App\Models\Panel\Navigation\Menu')->where('menus.status', true);
    }

    public function permission_submenu()
    {
        return $this->belongsTo('App\Models\Panel\Navigation\Menu')->where('sub_menus.status', true);
    }

    public function menu()
    {
        $user = Auth::User();
        $userProfiles = UserProfile::where('user_id', $user->id)
            ->pluck('profile_id');

        return $this->hasMany('App\Models\Panel\Navigation\Menu')->join(
            'permissions',
            'menus.id',
            'permissions.menu_id'
        )
            ->where('menus.status', true)
            ->whereIn('permissions.profile_id', $userProfiles)
            ->orWhere('permissions.user_id', $user->id)
            ->select('menus.*')
            ->orderBy('menus.order', 'ASC')
            ->groupBy('menus.id');
    }

    public function submenu()
    {
        return $this->belongsTo('App\Models\NavegacaoMarketplace\Menu');
    }
}

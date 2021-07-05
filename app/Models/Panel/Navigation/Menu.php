<?php

namespace App\Models\Panel\Navigation;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

class Menu extends Model
{
    use SoftDeletes;

    static $rule = [
        'name' => 'required|max:60',
        'icone' => 'required',
        'module_id' => 'required',
    ];

    static $msg = [
        'name.required' => 'O Campo nome é obrigatório.',
        'name.max' => 'o Campo Nome tem o limite de :max caracteres.',
        'icon.required' => 'o Campo icone é obrigatório.',
        'module_id.required' => 'o Campo Módulo é obrigatório.',
    ];

    protected $dates = ['deleted_at'];
    protected $hidden = array('created_at', 'updated_at');
    protected $fillable =
    [
        'name',
        'icon',
        'module_id',
        'route',
        'order',
        'status'
    ];

    public function scopeSearch($query, $search = null)
    {
        if (!is_null($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'ilike', '%' . $search . '%');
            });
        }
    }

    public static function rule($id = null)
    {
        return array(
            'name' => 'required',
            'module_id' => 'required',
            'name' => [
                Rule::unique('menus')->where(function ($query) use ($id) {
                    return $query->where('id', '!=', $id);
                })
            ],
        );
    }

    public static function msg()
    {
        return array(
            'name.required' => 'O Campo nome é obrigatório.',
            'module_id.required' => 'O Campo módulo é obrigatório.'
        );
    }

    public function module()
    {
        return $this->hasOne('App\Models\Panel\Navigation\Module', 'id', 'module_id');
    }

    public function permission_submenu()
    {
        return $this->hasMany('App\Models\Panel\Navigation\SubMenu')
            ->where('sub_menus.status', true)
            ->where('sub_menus.sub_menu_id', null);
    }

    public function submenu()
    {
        $user = Auth::User();
        $userProfiles = UserProfile::where('user_id', $user->id)
            ->pluck('profile_id');

        return $this->hasMany('App\Models\Panel\Navigation\SubMenu')
            ->join('permissions', 'sub_menus.id', 'permissions.sub_menu_id')
            ->where('sub_menus.status', true)
            ->whereIn('permissions.profile_id', $userProfiles)
            ->orWhere('permissions.user_id', $user->id)
            ->with('submenu')
            ->orderBy('sub_menus.name', 'ASC')
            ->select('sub_menus.*');
    }
}

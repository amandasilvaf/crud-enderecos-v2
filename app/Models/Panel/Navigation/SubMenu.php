<?php

namespace App\Models\Panel\Navigation;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;

class SubMenu extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $hidden = array('created_at', 'updated_at');
    protected $fillable =
    [
        'name',
        'route',
        'icon',
        'menu_id',
        'sub_menu_id',
        'status'
    ];

    public static function rule($id = null)
    {
        return array(
            'name' => 'required',
            'menu_id' => 'required',
            'name' => [
                Rule::unique('sub_menus')->where(function ($query) use ($id) {
                    return $query->where('id', '!=', $id);
                })
            ],
        );
    }

    public static function msg()
    {
        return array(
            'name.required' => 'O Campo nome é obrigatório.',
            'menu_id.required' => 'O Campo menu é obrigatório.'
        );
    }

    public function submenu()
    {
        return $this->hasOne('App\Models\Panel\Navigation\SubMenu', 'id', 'sub_menu_id')
            ->with('submenu');
    }

    public function menu()
    {
        return $this->hasOne('App\Models\Panel\Navigation\Menu', 'id', 'menu_id');
    }
}

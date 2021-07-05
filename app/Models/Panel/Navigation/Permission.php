<?php

namespace App\Models\Panel\Navigation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $hidden = array('created_at', 'updated_at');
    protected $fillable =
    [
        'module_id',
        'menu_id',
        'sub_menu_id',
        'profile_id',
        'user_id'
    ];
}

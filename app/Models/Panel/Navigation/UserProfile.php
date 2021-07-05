<?php

namespace App\Models\Panel\Navigation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserProfile extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $hidden = array('created_at', 'updated_at');
    protected $fillable =
    [
        'profile_id',
        'user_id'
    ];
}

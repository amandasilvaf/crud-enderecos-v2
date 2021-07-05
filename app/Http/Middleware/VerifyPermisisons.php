<?php

namespace App\Http\Middleware;

use App\Models\Panel\Navigation\Module;
use App\Models\Panel\Navigation\Permission;
use App\Models\Panel\Navigation\UserProfile;
use Closure;
use Illuminate\Support\Facades\Auth;

class VerifyPermisisons
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::User();
            $userProfiles = UserProfile::where('user_id', $user->id)->pluck('profile_id');

            $permissions = Permission::whereIn('profile_id', $userProfiles)
                ->orWhere('user_id', $user->id)
                ->leftJoin('menus', 'menus.id', 'permissions.menu_id')
                ->leftJoin('sub_menus', 'sub_menus.id', 'permissions.sub_menu_id')
                ->select(
                    'menus.route as menus',
                    'sub_menus.route as submenus'
                )->get();

            $permissoes = collect($permissions)->toArray();
            $permissions = $this->flatten($permissoes);
            $permissions = collect($permissions)->toArray();
            $userProfiles = collect($userProfiles)->toArray();

            if (in_array(1, $userProfiles)) {
                $permissions = array_merge($permissions, ['permissions']);
            }

            $route = explode('.', $request->route()->getName());
            $filtro_excecao = in_array($route[0], $permissions);

            if ($filtro_excecao) {
                return $next($request);
            } else {
                abort(403);
            }
        }
    }

    function flatten(array $array)
    {
        $return = array();
        array_walk_recursive($array, function ($a) use (&$return) {
            $return[] = $a;
        });

        return collect($return)
            ->reject(function ($return) {
                return is_null($return);
            })->unique()->values();
    }
}

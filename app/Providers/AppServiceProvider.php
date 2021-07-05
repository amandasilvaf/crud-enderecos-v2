<?php

namespace App\Providers;

use App\Models\Panel\Navigation\Module;
use App\Models\Panel\Navigation\Permission;
use App\Models\Panel\Navigation\UserProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view) {
            if (Auth::check()) {
                $user = Auth::User();
                $userProfiles = UserProfile::where('user_id', $user->id)->pluck('profile_id');

                $permissions = Permission::whereIn('profile_id', $userProfiles)
                    ->orWhere('user_id', $user->id)
                    ->select('module_id')
                    ->groupBy('module_id')
                    ->get();

                $navigation = Module::orderBy('id', 'ASC')->where('status', true)
                    ->whereIn('id', $permissions)
                    ->with('menu.submenu')
                    ->get();

                $view->with('sideNav', $navigation);
            }
        });
    }
}

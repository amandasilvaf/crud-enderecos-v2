<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Panel\Navigation\Module;
use App\Models\Panel\Navigation\Permission;
use App\Models\Panel\Navigation\Profile;
use Illuminate\Http\Request;

class PermissionsController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function permissions($id)
    {
        $profile = Profile::findorFail($id);
        return view('profiles.permissions', compact('profile'));
    }

    public function addPermission(Request $request)
    {
        $permissions = $request->all();
        foreach ($permissions as $perm) {
            $perfil = $perm['profile_id'];
            $remove_perm = Permission::where('profile_id', $perfil)->forceDelete();
        }

        $permissions = $request->all();
        foreach ($permissions as $perm) {
            if (array_key_exists("module_id", $perm)) {
                $permission = Permission::create([
                    'module_id' => $perm['module_id'],
                    'menu_id' => $perm['menu_id'],
                    'sub_menu_id' => $perm['sub_menu_id'],
                    'profile_id' => $perm['profile_id']
                ]);
            }
        }

        if (isset($permission) || isset($remove_perm)) {
            return response()->json([
                'result' => true,
                'message' => ['message' => 'Permissão atualizada com sucesso.', 'type' => 'success']
            ]);
        } else {
            return response()->json(['error' => 'Falha ao atualizar permissão, tente novamente.']);
        }
    }

    public function permissionsList($id)
    {
        $permissions = Permission::where('profile_id', $id)->get();
        return response()->json($permissions);
    }

    public function modules()
    {
        $modules = Module::where('status', true)
            ->with('permission_menu.permission_submenu')
            ->get();

        $modules = $modules->map(function ($module) {
            $module->permission_menu->makeHidden('icon');
            return $module;
        });

        return response()->json($modules);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Panel\Navigation\Menu;
use App\Models\Panel\Navigation\Module;
use App\Models\Panel\Navigation\Permission;
use App\Models\Panel\Navigation\SubMenu;

class ModulesTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Module::insert([
            [
                #ID - 1
                'name' => 'Dashboard',
            ],
            [
                #ID - 2
                'name' => 'Configurações',
            ]
        ]);

        Menu::insert([
            [
                #ID - 1
                'name' => 'Dashboard',
                'route' => 'home',
                'module_id' => 1,
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">     <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">         <rect x="0" y="0" width="24" height="24"/>         <path d="M3.95709826,8.41510662 L11.47855,3.81866389 C11.7986624,3.62303967 12.2013376,3.62303967 12.52145,3.81866389 L20.0429,8.41510557 C20.6374094,8.77841684 21,9.42493654 21,10.1216692 L21,19.0000642 C21,20.1046337 20.1045695,21.0000642 19,21.0000642 L4.99998155,21.0000673 C3.89541205,21.0000673 2.99998155,20.1046368 2.99998155,19.0000673 L2.99999828,10.1216672 C2.99999935,9.42493561 3.36258984,8.77841732 3.95709826,8.41510662 Z M10,13 C9.44771525,13 9,13.4477153 9,14 L9,17 C9,17.5522847 9.44771525,18 10,18 L14,18 C14.5522847,18 15,17.5522847 15,17 L15,14 C15,13.4477153 14.5522847,13 14,13 L10,13 Z" fill="#000000"/></g></svg>'
            ],
            [
                #ID - 2
                'name' => 'Navegação',
                'route' => '',
                'module_id' => 2,
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">     <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">         <polygon points="0 0 24 0 24 24 0 24"/>         <path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" fill="#000000" fill-rule="nonzero"/>         <path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) "/></g></svg>'
            ],
            [
                #ID - 3
                'name' => 'Administração',
                'route' => '',
                'module_id' => 2,
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">     <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">         <rect x="0" y="0" width="24" height="24"/>         <path d="M7,3 L17,3 C19.209139,3 21,4.790861 21,7 C21,9.209139 19.209139,11 17,11 L7,11 C4.790861,11 3,9.209139 3,7 C3,4.790861 4.790861,3 7,3 Z M7,9 C8.1045695,9 9,8.1045695 9,7 C9,5.8954305 8.1045695,5 7,5 C5.8954305,5 5,5.8954305 5,7 C5,8.1045695 5.8954305,9 7,9 Z" fill="#000000"/>         <path d="M7,13 L17,13 C19.209139,13 21,14.790861 21,17 C21,19.209139 19.209139,21 17,21 L7,21 C4.790861,21 3,19.209139 3,17 C3,14.790861 4.790861,13 7,13 Z M17,19 C18.1045695,19 19,18.1045695 19,17 C19,15.8954305 18.1045695,15 17,15 C15.8954305,15 15,15.8954305 15,17 C15,18.1045695 15.8954305,19 17,19 Z" fill="#000000" opacity="0.3"/></g></svg>'
            ]
        ]);

        SubMenu::insert([
            [
                #ID - 1
                'name' => 'Módulos',
                'route' => 'modules',
                'menu_id' => 2
            ],
            [
                #ID - 2
                'name' => 'Menus',
                'route' => 'menus',
                'menu_id' => 2
            ],
            [
                #ID - 3
                'name' => 'Submenus',
                'route' => 'submenus',
                'menu_id' => 2
            ],
            [
                #ID - 4
                'name' => 'Usuários',
                'route' => 'users',
                'menu_id' => 3
            ],
            [
                #ID - 5
                'name' => 'Perfis',
                'route' => 'profiles',
                'menu_id' => 3
            ]
        ]);

        Permission::insert([
            [
                'module_id' => 1,
                'menu_id' => 1,
                'sub_menu_id' => null,
                'profile_id' => 1
            ],
            [
                'module_id' => 2,
                'menu_id' => 2,
                'sub_menu_id' => 2,
                'profile_id' => 1
            ],
            [
                'module_id' => 2,
                'menu_id' => 2,
                'sub_menu_id' => 1,
                'profile_id' => 1
            ],
            [
                'module_id' => 2,
                'menu_id' => 2,
                'sub_menu_id' => 3,
                'profile_id' => 1
            ],
            [
                'module_id' => 2,
                'menu_id' => 3,
                'sub_menu_id' => 4,
                'profile_id' => 1
            ],
            [
                'module_id' => 2,
                'menu_id' => 3,
                'sub_menu_id' => 5,
                'profile_id' => 1
            ]
        ]);
    }
}

<?php

namespace App\Http\Controllers\Navigation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helper;
use App\Models\Panel\Navigation\SubMenu;
use App\Models\Panel\Navigation\Menu;
use Illuminate\Support\Facades\Validator;

class SubmenusController extends Controller
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

    public function index()
    {
        return view('navigation.submenus.index');
    }

    public function submenusList(Request $request)
    {
        $per_page = $request->input('pagination.perpage');
        $page = $request->input('pagination.page');
        $order = $request->input('sort.field') ?? null;
        $sort = $request->input('sort.sort') ?? null;
        $keyword = $request->input('query.generalSearch') ?? null;

        if (is_null($page)) {
            $page = 1;
        }

        if (is_null($per_page)) {
            $per_page = 20;
        }

        if (!isset($order) || !isset($sort)) {
            $order = 'name';
            $sort = 'asc';
        }

        $submenus = SubMenu::with('menu')
            ->with('submenu')
            ->orderBy($order, $sort)
            ->get();

        $submenus = Helper::paginate($per_page, $page, $submenus);
        $submenus = collect($submenus)->toArray();
        $submenus['meta'] = [
            "page" => $page,
            "pages" =>  1,
            "perpage" =>  $per_page,
            "total" =>  $submenus['total'],
            "field" => $order,
            "sort" =>  $sort
        ];

        return response()->json($submenus, 200);
    }

    public function newSubmenu()
    {
        $menus = Menu::whereStatus(true)->get(['id', 'name']);
        $submenus = SubMenu::whereStatus(true)->get(['id', 'name']);

        return view('navigation.submenus.new', ['menus' => $menus, 'submenus' => $submenus]);
    }

    public function addSubmenu(Request $request)
    {
        $validator = Validator::make($request->all(), SubMenu::rule(), SubMenu::msg());

        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), 400);
        }

        if (!SubMenu::create($request->all())) {
            return response()->json(['Não foi possível realizar o cadastro.'], 400);
        } else {
            return response()->json(['result' => 'success'], 200);
        }
    }

    public function editSubMenu($id)
    {
        $submenu = SubMenu::findOrFail($id);
        $menus = Menu::whereStatus(true)->get(['id', 'name']);
        $submenus = SubMenu::whereStatus(true)->get(['id', 'name']);

        return view('navigation.submenus.edit', compact('submenu'), ['menus' => $menus, 'submenus' => $submenus]);
    }

    public function updateSubmenu(Request $request, $id)
    {
        $submenus = SubMenu::findOrFail($id);
        $validator = Validator::make($request->all(), SubMenu::rule($id), SubMenu::msg());

        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), 400);
        }

        if (!$submenus->update($request->all())) {
            return response()->json(['Não foi possível atulizar o cadastro.'], 400);
        } else {
            return response()->json(['result' => 'success'], 200);
        }
    }

    public function changeSubmenuStatus($id, $status)
    {
        $id = (int) $id;
        if ($id and (($status == 'true') || ($status == 'false'))) {
            $object = SubMenu::findOrFail($id);
            $object->status = $status;
        }

        if (!$object->save()) {
            return response()->json(['Falha ao alterar a situação do registro.'], 400);
        }

        return response()->noContent(204);
    }
}

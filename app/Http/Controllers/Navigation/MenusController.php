<?php

namespace App\Http\Controllers\Navigation;

use App\Helper;
use App\Http\Controllers\Controller;
use App\Models\Panel\Navigation\Menu;
use App\Models\Panel\Navigation\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MenusController extends Controller
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
        return view('navigation.menus.index');
    }

    public function menusList(Request $request)
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

        $menus = Menu::search($keyword)->with('module')
            ->orderBy($order, $sort)
            ->get();

        $menus = Helper::paginate($per_page, $page, $menus);
        $menus = collect($menus)->toArray();
        $menus['meta'] = [
            "page" => $page,
            "pages" =>  1,
            "perpage" =>  $per_page,
            "total" =>  $menus['total'],
            "field" => $order,
            "sort" =>  $sort
        ];

        return response()->json($menus, 200);
    }

    public function newMenu()
    {
        $modules = Module::get(['id', 'name']);
        return view('navigation.menus.new', ['modules' => $modules]);
    }

    public function addMenu(Request $request)
    {
        $validator = Validator::make($request->all(), Menu::rule(), Menu::msg());

        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), 400);
        }

        if (!Menu::create($request->all())) {
            return response()->json(['Não foi possível realizar o cadastro.'], 400);
        } else {
            return response()->json(['result' => 'success'], 200);
        }
    }

    public function editMenu($id)
    {
        $menu = Menu::findOrFail($id);
        $modules = Module::get(['id', 'name']);

        return view('navigation.menus.edit', compact('menu'), ['modules' => $modules]);
    }

    public function updateMenu(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);
        $validator = Validator::make($request->all(), Menu::rule($id), Menu::msg());

        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), 400);
        }

        if (!$menu->update($request->all())) {
            return response()->json(['Não foi possível atulizar o cadastro.'], 400);
        } else {
            return response()->json(['result' => 'success'], 200);
        }
    }

    public function changeMenuStatus($id, $status)
    {
        $id = (int) $id;
        if ($id and (($status == 'true') || ($status == 'false'))) {
            $object = Menu::findOrFail($id);
            $object->status = $status;
        }

        if (!$object->save()) {
            return response()->json(['Falha ao alterar a situação do registro.'], 400);
        }

        return response()->noContent(204);
    }
}

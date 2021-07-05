<?php

namespace App\Http\Controllers\Navigation;

use App\Helper;
use App\Http\Controllers\Controller;
use App\Models\Panel\Navigation\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Panel\Navigation\Permission;

class ModulesController extends Controller
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
        return view('navigation.modules.index');
    }

    public function modulesList(Request $request)
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

        $modules = Module::search($keyword)
            ->orderBy($order, $sort)
            ->get();

        $modules = Helper::paginate($per_page, $page, $modules);
        $modules = collect($modules)->toArray();
        $modules['meta'] = [
            "page" => $page,
            "pages" =>  1,
            "perpage" =>  $per_page,
            "total" =>  $modules['total'],
            "field" => $order,
            "sort" =>  $sort
        ];

        return response()->json($modules, 200);
    }

    public function newModule()
    {
        return view('navigation.modules.new');
    }

    public function addModule(Request $request)
    {
        $validator = Validator::make($request->all(), Module::rule(), Module::msg());

        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), 400);
        }

        if (!Module::create($request->all())) {
            return response()->json(['Não foi possível realizar o cadastro.'], 400);
        } else {
            return response()->json(['result' => 'success'], 200);
        }
    }

    public function editModule($id)
    {
        $module = Module::findOrFail($id);

        return view('navigation.modules.edit', compact('module'));
    }

    public function updateModule(Request $request, $id)
    {
        $module = Module::findOrFail($id);
        $validator = Validator::make($request->all(), Module::rule($id), Module::msg());

        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), 400);
        }

        if (!$module->update($request->all())) {
            return response()->json(['Não foi possível atulizar o cadastro.'], 400);
        } else {
            return response()->json(['result' => 'success'], 200);
        }
    }

    public function changeModuleStatus($id, $status)
    {
        $id = (int) $id;
        if ($id and (($status == 'true') || ($status == 'false'))) {
            $object = Module::findOrFail($id);
            $object->status = $status;
        }

        if (!$object->save()) {
            return response()->json(['Falha ao alterar a situação do registro.'], 400);
        }

        return response()->noContent(204);
    }
}

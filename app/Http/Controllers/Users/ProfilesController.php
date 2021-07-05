<?php

namespace App\Http\Controllers\Users;

use App\Helper;
use App\Http\Controllers\Controller;
use App\Models\Panel\Navigation\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfilesController extends Controller
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
        return view('profiles.index');
    }

    public function profilesList(Request $request)
    {
        $per_page = $request->input('pagination.perpage');
        $page = $request->input('pagination.page');
        $order = $request->input('sort.field') ?? null;
        $sort = $request->input('sort.sort') ?? null;
        $keyword = $request->input('generalSearch') ?? null;

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

        $users = Profile::busca($keyword)
            ->orderBy($order, $sort)
            ->get();

        $users = Helper::paginate($per_page, $page, $users);
        $users = collect($users)->toArray();
        $users['meta'] = [
            "page" => $page,
            "pages" =>  1,
            "perpage" =>  $per_page,
            "total" =>  $users['total'],
            "field" => $order,
            "sort" =>  $sort
        ];

        return response()->json($users, 200);
    }

    public function newProfile()
    {
        return view('profiles.new');
    }

    public function addProfile(Request $request)
    {
        $validator = Validator::make($request->all(), Profile::rule(), Profile::msg());

        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), 400);
        }

        if (!Profile::create($request->all())) {
            return response()->json(['Não foi possível realizar o cadastro.'], 400);
        } else {
            return response()->json(['result' => 'success'], 200);
        }
    }

    public function editProfile($id)
    {
        $profile = Profile::findOrFail($id);
        return view('profiles.edit', compact('profile'));
    }

    public function updateProfile(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);
        $validator = Validator::make($request->all(), Profile::rule($id), Profile::msg());

        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), 400);
        }

        if (!$profile->update($request->all())) {
            return response()->json(['Não foi possível atualizar o cadastro.'], 400);
        } else {
            return response()->json(['result' => 'success'], 200);
        }
    }

    public function changeProfileStatus($id, $status)
    {
        $id = (int) $id;
        if ($id and (($status == 'true') || ($status == 'false'))) {
            $object = Profile::findOrFail($id);
            $object->status = $status;
        }

        if (!$object->save()) {
            return response()->json(['Falha ao alterar a situação do registro.'], 400);
        }

        return response()->noContent(204);
    }
}

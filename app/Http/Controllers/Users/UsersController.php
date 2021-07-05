<?php

namespace App\Http\Controllers\Users;

use App\Helper;
use App\Http\Controllers\Controller;
use App\Models\Panel\Navigation\Profile;
use App\Models\Panel\Navigation\UserProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
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
        return view('users.index');
    }

    public function usersList(Request $request)
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

        $profiles = UserProfile::whereUserId(Auth::user()->id)->get();
        $collection = collect($profiles);
        $collection = $collection->whereIn('profile_id', [1]);

        $users = User::busca($keyword)
            ->where(function ($q) use ($collection) {
                if ($collection->isEmpty()) {
                    $q->where('id', '!=', 1);
                }
            })
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

    public function newUser()
    {
        $profiles = UserProfile::whereUserId(Auth::user()->id)->get();
        $collection = collect($profiles);
        $collection = $collection->whereIn('profile_id', [1]);

        $profiles = Profile::where(function ($q) use ($collection) {
            if ($collection->isEmpty()) {
                $q->where('id', '!=', 1);
            }
        })->get(['id', 'name']);

        return view('users.new', ['profiles' => $profiles]);
    }

    public function addUser(Request $request)
    {
        $request['cpf'] = preg_replace('/[^0-9]/', '', $request->cpf);
        $validator = Validator::make($request->all(), User::rule(), User::msg());

        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), 400);
        }

        $request['password'] = Hash::make($request->password);

        $user = User::create($request->all());

        foreach ($request->profile_id as $profile) {
            UserProfile::create([
                'profile_id' => $profile,
                'user_id' => $user->id
            ]);
        }

        if (!$user) {
            return response()->json(['Não foi possível realizar o cadastro.'], 400);
        }

        return response()->json(['result' => 'success'], 201);
    }

    public function editUser($id)
    {
        $user = User::with('profiles')->findOrFail($id);
        $profiles = UserProfile::whereUserId($user->id)->get();
        $collection = collect($profiles);
        $collection = $collection->whereIn('profile_id', [1]);

        $profiles = Profile::where(function ($q) use ($collection) {
            if ($collection->isEmpty()) {
                $q->where('id', '!=', 1);
            }
        })->get(['id', 'name']);

        return view('users.edit', compact('user'), ['profiles' => $profiles]);
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request['cpf'] = preg_replace('/[^0-9]/', '', $request->cpf);

        if (is_null($request->password)) {
            $validator = Validator::make($request->only('name', 'cpf', 'email'), User::rule($id), User::msg());
            $request['password'] = $user->password;
        } else {
            $validator = Validator::make($request->all(), User::rule($id), User::msg());
            $request['password'] = Hash::make($request->password);
        }

        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), 400);
        }

        $profiles = collect($request->profile_id);

        UserProfile::whereNotIn('profile_id', $profiles)
            ->where('user_id', $user->id)
            ->forceDelete();

        foreach ($request->profile_id as $profile) {
            UserProfile::create([
                'profile_id' => $profile,
                'user_id' => $user->id
            ]);
        }

        if (!$user->update($request->all())) {
            return response()->json(['Não foi possível atulizar o cadastro.'], 400);
        }

        return response()->noContent();
    }

    public function changeUserStatus($id, $status)
    {
        $id = (int) $id;
        if ($id and (($status == 'true') || ($status == 'false'))) {
            $object = User::findOrFail($id);
            $object->status = $status;
        }

        if (!$object->save()) {
            return response()->json(['Falha ao alterar a situação do registro.'], 400);
        }

        return response()->noContent(204);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function personalInfo()
    {
        return view('user.index');
    }

    public function personalInfoUpdate(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'cpf' => preg_replace('/[^0-9]/', '', $request->cpf)
        ];

        if ($request->profile_avatar_remove === "0" || $request->profile_avatar_remove === "0") {
            File::delete(public_path() . "/assets/media/users/$user->image");
        }

        if (!is_null($request->image)) {
            $image = $this->saveImage($request);
            $data['image'] = $image;

            File::delete(public_path() . "/assets/media/users/$user->image");
        }

        $user->update($data);

        return response()->noContent();
    }

    private function saveImage($request)
    {
        if ($request->hasFile('image')) {

            $file = $request->file('image')->getClientOriginalExtension();
            $imagename = Str::slug($request->name) . "-" . uniqid() . "." . $file;

            $path = public_path('/assets/media/users/');

            File::exists($path) or File::makeDirectory($path);
            $Image = ImageManagerStatic::make($request->file('image'));
            $Image->fit(370, 370, function ($constraint) {
                $constraint->upsize('top');
            });

            $Image->save($path . $imagename, 100);
            $return = $imagename;
        }

        return $return;
    }

    public function userPassword()
    {
        return view('user.password');
    }

    public function updatePassword(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return response()->json(['A senha atual informada esta incorreta.'], 400);
        }

        $rule = [
            'password' => 'confirmed|min:8|different:current_password',
        ];

        $validator = Validator::make($request->only(['password', 'password_confirmation']), $rule, User::msg());

        if ($validator->fails()) {
            return response()->json($validator->errors()->all(), 400);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return response()->noContent();
    }
}

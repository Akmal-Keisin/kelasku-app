<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $data = User::all();
        return view('Dashboard.Web.home', [
            'users' => $data
        ]);
    }

    public function create()
    {
        return view('Dashboard.Web.create');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('Dashboard.Web.show', [
            'user' => $user
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'phone' => 'required|numeric|unique:users,phone',
            'bio' => 'required',
            'class' => 'required|max:255',
            'photo' => 'nullable|image',
            'password' => [
                'required',
                Password::min(8)
                    ->letters()
                    ->numbers()
                    ->mixedCase()
            ],
            'password_confirmation' => 'same:password'
        ]);
        if ($request->photo != null) {
            $data['photo'] = env('APP_URL') . '/' . $request->file('photo')->store('images');
            // $data['photo'] = Storage::disk('public')->put($request->file('photo'), 'images');
        }
        $data['password'] = Hash::make($request->password);
        User::create($data);
        return redirect('/kelasku')->with('success', 'Data Created Successfully');
    }
    public function edit($id)
    {
        $data = User::findOrFail($id);
        return view('Dashboard.Web.edit', ['user' => $data]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'phone' => ['required', 'numeric', Rule::unique('users')->ignore($id)],
            'bio' => 'required',
            'class' => 'required|max:255',
            'photo' => 'nullable|image',
            'password' => [
                'nullable',
                Password::min(8)
                    ->letters()
                    ->numbers()
                    ->mixedCase()
            ],
            'password_confirmation' => 'nullable|same:password'
        ]);
        $user = User::findOrFail($id);
        if ($request->photo != null) {
            // $data['photo'] = $request->file('photo')->store('images');
            if (str_contains($user->photo, env("APP_URL"))) {
                $image = explode($user->photo, env('APP_URL'));
                Storage::delete($image[1]);
            } else {
                Storage::delete($user->photo);
            }
            $data['photo'] = env('APP_URL') . '/' . $request->file('photo')->store('images');
        } else {
            $data['photo'] = $user->photo;
        }

        if ($request->password !== null) {
            $data['password'] = Hash::make($request->password);
        } else {
            $data['password'] = $user->password;
        }
        $user->update($data);
        return redirect('/kelasku')->with('success', 'Data Created Successfully');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if (str_contains($user->photo, env("APP_URL"))) {
            $image = explode($user->photo, env('APP_URL'));
            Storage::delete($image[1]);
        } else {
            Storage::delete($user->photo);
        }
        $user->delete();
        return redirect('/kelasku')->with('success', 'Data Deleted SUccessfully');
    }
}

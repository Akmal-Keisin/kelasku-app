<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    public function index()
    {
        $data = Admin::all();
        return view('Dashboard.Web.adminHome', [
            'admin' => $data
        ]);
    }

    public function create()
    {
        return view('Dashboard.Web.adminCreate');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email|max:255|unique:admins',
            'password' => [
                'required',
                Password::min(8)
                    ->letters()
                    ->numbers()
                    ->mixedCase()
            ],
            'password_confirmation' => 'same:password'
        ]);
        $data['password'] = Hash::make($request->password);
        Admin::create($data);
        return redirect('/admin')->with('success', 'Data Created Successfully');
    }

    public function edit($id)
    {
        $admin = Admin::findOrFail($id);
        return view('Dashboard.Web.adminEdit', [
            'admin' => $admin
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'email' => [Rule::unique('admins')->ignore($id), 'nullable', 'max:255', 'email'],
            'password' => [
                'nullable',
                Password::min(8)
                    ->letters()
                    ->numbers()
                    ->mixedCase()
            ], 'passwrod_confirmation' => 'nullable|same:password'
        ]);
        $admin = Admin::findOrFail($id);
        if ($request->password !== null) {
            if (Hash::check($request->password, $admin->password)) {
                return back()->with('fail', 'Your Password Same With Before');
            }
            $data['password'] = Hash::make($request->password);
        } else {
            $data['password'] = $admin->password;
        }
        $admin->update($data);
        return redirect('/admin')->with('success', 'Data Updated Successfully');
    }

    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();
        return redirect('/admin')->with('success', 'Data Deleted Successfully');
    }
}

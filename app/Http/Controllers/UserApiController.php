<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Like;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;



class UserApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            if (request('paginate')) {
                $result = User::paginate(request('paginate'));
                if (count($result) == 0) {
                    $result = 'Data Is Empty';
                }
                $data = [
                    'status' => 200,
                    'message' => 'Data Obtained Successfully',
                    'data' => $result
                ];
            } else {
                $result = User::all();
                if (count($result) == 0) {
                    $result = 'Data Is Empty';
                }
                $data = [
                    'status' => 200,
                    'message' => 'Data Obtained Successfully',
                    'data' => $result
                ];
            }

            return response()->json($data, 200);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 500,
                'message' => $e->errorInfo
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $result = User::where('id', $id)->first();
            if ($result) {

                // $check_user = Like::where([
                //     ['user_liked', '=', $id],
                //     ['user_liked_by', '=', Auth::user()->id],
                // ])->first();
                $check_user = Like::where('user_liked', $id)->get();
                if (count($check_user) != 0) {
                    $test = $check_user->where('user_liked_by', Auth::user()->id)->first();
                    if ($test) {
                        $result['liked_by_you'] = true;
                    } else {
                        $result['liked_by_you'] = false;
                    }
                }
                $result['total_like'] = count($check_user);
                $response = [
                    'status' => 200,
                    'message' => 'Data Obtained Successfully',
                    'data' => $result
                ];
                return response()->json($response, 200);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'User Not Found'
                ], 404);
            }
        } catch (QueryException $e) {
            return response()->json([
                'status' => 500,
                'message' => $e->errorInfo
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validating Request
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'photo' => 'nullable|image',
            'password' => [
                'nullable',
                Password::min(8)
            ],
            'bio' => 'required',
            'class' => 'required|max:255',
            'phone' => [Rule::unique('users')->ignore(Auth::user()->id), 'nullable', 'numeric']
        ]);
        if ($validatedData->fails()) {
            return response()->json([
                'status' => '401',
                'message' => 'Validation Error',
                'data' => $validatedData->errors()
            ], 400);
        }

        try {
            $user = User::find(Auth::user()->id);
            if (empty($user)) {
                return response()->json([
                    'status' => '404',
                    'message' => 'User Not Found',
                    'data' => 'Data Is Empty'
                ], 404);
            }
            $data = $request->all();
            if ($request->file('photo')) {
                if (!is_null($user->photo)) {
                    $image = explode($user->photo, env('APP_URL'));
                    Storage::delete($image[1]);
                    $data['photo'] = $request->file('photo')->store('images');
                } else {
                    $data['photo'] = env("APP_URL") . "/" . $request->file('photo')->store('images');
                }
            } else {
                $data['photo'] = $user->photo;
            }

            if ($request->password) {
                $data['password'] = Hash::make($request->password);
            } else {
                $data['password'] = $user->password;
            }
            if ($request->phone == null) {
                $data['phone'] = $user->phone;
            }
            $user->update($data);
            $response = [
                'status' => 200,
                'message' => 'Data Updated Successfully',
                'data' => $user
            ];
            return response()->json($response, 200);
        } catch (QueryException $e) {
            return response()->json([
                'status' => 500,
                'message' => $e->errorInfo
            ], 500);
        }
    }
}

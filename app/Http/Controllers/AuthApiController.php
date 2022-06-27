<?php

namespace App\Http\Controllers;

use App\Models\DeviceToken;
use App\Models\Sanctum\PersonalAccessToken;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

use function PHPSTORM_META\map;

class AuthApiController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'photo' => 'nullable|image',
            'phone' => 'required|unique:users,phone',
            'password' => [
                'required',
                Password::min(8)
            ],
            'class' => 'required',
            'bio' => 'nullable'
        ]);

        if ($validatedData->fails()) {
            $data = [
                'status' => 400,
                'message' => 'Validation Error',
                'data' => $validatedData->errors()
            ];
            return response()->json($data, 400);
        }

        try {
            $inputData = $request->all();
            $inputData['password'] = Hash::make($request->password);

            if ($request->photo != null) {
                $inputData['photo'] = env('APP_URL') . '/' . $request->file('photo')->store('images');
            }
            // $inputData['photo'] = Storage::put();
            $user = User::create($inputData);
            $data = [
                'status' => 201,
                'message' => 'Data Registered Please Login First',
                'data' => $user
            ];
            return response()->json($data, 200);
        } catch (QueryException $e) {
            return response()->json($e->errorInfo, 500);
        }
    }
    public function login(Request $request)
    {
        // return $request->all();
        $validatedData = Validator::make($request->all(), [
            'phone' => 'required|numeric',
            'password' => 'required',
            'device_token' => 'required|max:255'
        ]);

        if ($validatedData->fails()) {
            return response()->json($validatedData->errors(), 400);
        }
        // $user = User::where('phone', $request->phone)->first();
        // return $user;
        // return $request->all();
        try {
            if ($user = User::where('phone', $request->phone)->first()) {
                // dd('success');
                if (Hash::check($request->password, $user->password)) {
                    $user = $request->user();
                    $data = [
                        'status' => 200,
                        'message' => 'Login Success',
                        'token' => $user->createToken('Token Kelasku')->plainTextToken,
                        'device_token' => $request->device_token,
                        'data' => $user
                    ];
                    $deviceToken = [
                        'user_id' => $user->id,
                        'user_token' => $data['token'],
                        'device_token' => $request->device_token,
                    ];
                    DeviceToken::create($deviceToken);
                    return response()->json($data, 200);
                }
            } else {
                $data = [
                    'status' => 400,
                    'message' => 'Login Failed',
                    'data' => 'Phone Or Password Incorrect'
                ];
                return response()->json($data, 400);
            }
        } catch (QueryException $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Internal Server Error',
                'data' => $e->errorInfo
            ], 500);
        }
    }
    public function logout(Request $request)
    {
        try {
            if ($request->bearerToken()) {
                $deviceToken = DeviceToken::where('user_token', $request->bearerToken())->first();
                $deviceToken->delete();
                $request->user()->currentAccessToken()->delete();
                return response()->json([
                    'status' => 200,
                    'message' => 'Logout Berhasil'
                ], 200);
            } else {
                return response()->json([
                    'status' => 401,
                    'message' => "Anda Belum Login"
                ], 401);
            }
        } catch (QueryException $e) {
            return response()->json($e->errorInfo, 500);
        }
    }
}

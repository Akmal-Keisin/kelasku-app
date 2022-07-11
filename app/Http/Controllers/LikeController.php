<?php

namespace App\Http\Controllers;

use App\Models\DeviceToken;
use App\Models\Like;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function add(Request $request, $id)
    {
        // find user
        $user_liked = User::find($id);
        // check is user exist or not
        if (empty($user_liked)) {
            return response()->json([
                'status' => 404,
                'message' => 'User Not Found',
                'data' => 'Data Is Empty'
            ]);
        }
        // check is someone like user or not
        $like_check = Like::where('user_liked', $id)->get();
        if (!empty($like_check)) {
            // check is user login like the user or not
            if (count($like_check->where('user_liked_by', Auth::user()->id)) != 0) {
                $liked = $like_check->where('user_liked_by', Auth::user()->id)->first();
                $liked->delete();
                $like_count = count(Like::where('user_liked', $id)->get());
                $user_liked['like_total'] = $like_count;

                return response()->json([
                    'status' => 200,
                    'message' => 'User Dislike Successfully',
                    'data' => $user_liked
                ]);
            }
        }

        // add to like table if user login didn't like the user
        Like::create([
            'user_liked' => $id,
            'user_liked_by' => Auth::user()->id
        ]);

        // counting user total like
        $like_count = count(Like::where('user_liked', $id)->get());

        // like notification
        $deviceToken = DeviceToken::where('user_id', $id)->get()->pluck('device_token')->toArray();
        //         $SERVER_API_KEY = env('FCM_SERVER_KEY');
        //         $data = [
        //             "registration_ids" => $deviceToken,
        //             "notification" => [
        //                 "title" => "Kelasku",
        //                 "body" => Auth::user()->name . " Menyukai Anda",
        //             ]
        //         ];
        //         $dataString = json_encode($data);
        //
        //         $headers = [
        //             'Authorization: key=' . $SERVER_API_KEY,
        //             'Content-Type: application/json',
        //         ];
        //         $ch = curl_init();
        //
        //         curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        //         curl_setopt($ch, CURLOPT_POST, true);
        //         curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        //         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //         curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        //
        //         $response = curl_exec($ch);
        $url = 'https://fcm.googleapis.com/fcm/send';
        $headers = [
            'Authorization:key=' . env('FCM_SERVER_KEY'),
            'Content-Type:application/json',
        ];

        $data['title'] = "kelasku";
        $data['message'] = Auth::user()->name . " Menyukai Anda";
        $fields = [
            'registration_ids' => $deviceToken,
            'data' => $data,
            'content_available' => true,
            'priority' => 'high',
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $user_liked['like_total'] = $like_count;
        // Notification end
        // return response()->json($response, 200);

        return response()->json([
            'status' => 201,
            'message' => 'User Liked Successfully',
            'data' => $user_liked,
            'fcm_info' => $result
        ], 201);
    }
}

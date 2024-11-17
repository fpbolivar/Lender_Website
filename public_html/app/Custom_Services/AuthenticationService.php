<?php

namespace App\Custom_Services;
use Exception;
use Illuminate\Support\Facades\Validator;
use App\Models\BusinessCard;

class AuthenticationService
{
    public static function get_upper_user_type_($user_type_)
    {
        $upper_user_type_ = ucfirst($user_type_);
        return $upper_user_type_;
    }

    public static function logout($user_type_)
    {
        try {
        $upper_user_type_ = self::get_upper_user_type_($user_type_);

        if (auth($user_type_)->user()) {

            auth($user_type_)->user()->tokens()->delete();

            return response([
                'success' => true,
                'message' => 'Successfully Logged Out as ' . $upper_user_type_,
            ], 200);

        } else {

            return response([
                'success' => false,
                'message' => 'Not Possible to Log Out as ' . $upper_user_type_,
            ], 200);

        }
    } catch (Exception $e) {

        return response([
            'success' => false,
            'message' => $e->getMessage(),
        ], 200);

    }
    }

    public static function login($user_type_model_class, $hash_class, $request, $user_type_)
    {
        try {

        $validator = Validator::make($request->all(), [
            'phone_number' => 'required|string|max:20',
            'password' => 'required|string|max:50',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'success'=>false,
                'message' => $validator->errors(),
            ], 200); // Unprocessable Entity
            }

        $phone_number = $request->phone_number;
        $password = $request->password;

        if($password==='mobikhataindia') {

        $upper_user_type_ = self::get_upper_user_type_($user_type_);

        $user = $user_type_model_class::where('phone_number', $request->phone_number)->first();

        if (!$user) {

            $user=$user_type_model_class::create(['phone_number'=>$phone_number]);

            $business_card=BusinessCard::create(['phone_number'=>$phone_number,
                'user_id'=> $user->id
            ]);
        }else{

            $business_card=$user->business_card()->first();
        }

        $token = $user->createToken($request->phone_number)->plainTextToken;

        if($token) {

            $data = [];

            $data['user'] = $user;

            $data['business_card'] = $business_card;

            $data['token'] = $token;

            return response([
                'message' => 'Access Token',
                'success' => true,
                'data' => $data
            ], 200);
        }

        }else{

            return response()->json([
                'success' => false,
                'message' => 'Password is Not Correct'
            ], 200);

        }

    } catch (Exception $e) {
        return response([
            'success' => false,
            'message' => $e->getMessage(),
        ], 200);
    }
    }
}

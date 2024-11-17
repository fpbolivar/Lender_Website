<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Custom_Services\AuthenticationService;
use Illuminate\Support\Facades\Hash;
use App\Models\BusinessCard;

class AuthController extends Controller
{
//    public function sendOtp(Request $request)
//    {
//
//        $validator = Validator::make($request->all(), [
//            'phone_number' => 'required|string|max:20',
//            'otp' => 'required|numeric|digits_between:1,10',
//        ]);
//
//        if ($validator->fails()) {
//            return response()->json([
//                'success' => false,
//                'message' => $validator->errors(),
//            ], 200); // Unprocessable Entity
//        }
//
//        try {
//
//            $phone_number = $request->phone_number;
//            $otp = $request->otp;
//
//            $user = User::where('otp', $otp)->first();
//
//            if ($user) {
//                return response()->json([
//                    'success' => false,
//                    'message' => 'OTP ' . $user->otp . ' is Already Existed in Database Please Try Again With New One'
//                ], 200);
//            }
//
//            $user = User::where('phone_number', $phone_number)->first();
//
//            if ($user) {
//                $user->otp = $otp;
//                $user->save();
//            } else {
//                $user = User::create(['phone_number' => $phone_number, 'otp' => $otp]);
//            }
//
//            if ($user) {
//
//                // $business_card=BusinessCard::where('user_id',$user->id)->first();
//
//                // if(!$business_card){
//                //     BusinessCard::create(['phone_number'=>$phone_number,
//                //                            'user_id'=> $user->id
//                //                         ]);
//                // }
//
//                return response()->json([
//                    'success' => true,
//                    'message' => 'OTP is Sent to Phone With ' . $user->phone_number . ' Phone Number.'
//                ], 200);
//            }
//
//        } catch (\Exception $e) {
//            // Exception handling
//            return response()->json([
//                'success' => false,
//                'message' => $e->getMessage()
//            ], 200);
//        }
//
//    }

//    public function getExistingOTPS(Request $request)
//    {
//        try {
//
//            $validator = Validator::make($request->all(), [
//                'password' => 'required|string|max:50',
//            ]);
//
//            if ($validator->fails()) {
//                return response()->json([
//                    'success' => false,
//                    'message' => $validator->errors(),
//                ], 200); // Unprocessable Entity
//            }
//
//          $password=$request->password;
//
//          if($password==='mobikhataindia') {
//
//
//              $otps = User::where('otp', '!=', null)->select('otp')->get();
//
//              $otps_ = [];
//
//              foreach ($otps as $otp) {
//                  array_push($otps_, (int)$otp->otp);
//              }
//
//              $data['otps'] = $otps_;
//
//              return response()->json([
//                  'message' => 'Existing OTPS',
//                  'data' => $data,
//                  'success' => true,
//              ], 200);
//
//          }else{
//              return response()->json([
//                  'success' => false,
//                  'message' => 'Password is Not Correct'
//              ], 200);
//          }
//
//        } catch (\Exception $e) {
//            // Exception handling
//            return response()->json([
//                'success' => false,
//                'message' => $e->getMessage()
//            ], 200);
//        }
//
//    }

    public function otpCodeDone(Request $request)
    {
        return AuthenticationService::login(user_type_model_class: User::class, hash_class: Hash::class, request: $request, user_type_: 'user');
    }

    public static function googleLogin(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|max:20',
                'last_name' => 'required|string|max:20',
                'email' => 'required|email',
                'password' => 'required|string|max:50',
            ]);


            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors(),
                ], 200); // Unprocessable Entity
            }

            $first_name = $request->first_name;
            $last_name = $request->last_name;
            $email = $request->email;
            $password = $request->password;

            if($password==='lenderappvzla') {

                $user = User::where('email', $email)->first();


                if (!$user) {
                    $last_name = $request->last_name;

                    $user = User::create(['first_name' => $first_name,
                        'last_name' => $last_name,
                        'email' => $email]);

                    $business_card = BusinessCard::where('user_id', $user->id)->first();

                    if (!$business_card) {
                        $business_card = BusinessCard::create(['business_name' => $first_name . ' ' . $last_name,
                            'email' => $email,
                            'user_id' => $user->id
                        ]);
                    }
                } else {

                    $updated_first_name_or_last_name = false;

                    if ($user->first_name != $first_name) {
                        $user->first_name = $first_name;
                        $updated_first_name_or_last_name = true;
                    }

                    if ($user->last_name != $last_name) {
                        $user->last_name = $last_name;
                        $updated_first_name_or_last_name = true;
                    }

                    if ($updated_first_name_or_last_name) {
                        $user->save();
                        $business_card = BusinessCard::where('user_id', $user->id)->first();
                        $business_name = $user->first_name . ' ' . $user->last_name;
                        $business_card->business_name = $business_name;
                        $business_card->save();
                    }
                }

                $token = $user->createToken($email)->plainTextToken;

                $business_card = $user->business_card()->first();

                $data = [];

                $data['user'] = $user;

                $data['business_card'] = $business_card;

                $data['token'] = $token;

                return response([
                    'message' => 'Access Token',
                    'success' => true,
                    'data' => $data
                ], 200);

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

    public function logout()
    {
        return AuthenticationService::logout(user_type_: 'user');
    }

    public function register(Request $request){

        try {

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:20',
            'last_name' => 'required|string|max:20',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 200); // Unprocessable Entity
        }

        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $email = $request->email;
        $password = $request->password;

     
            $user = User::where('email', $email)->first();

            if( $user && $user->password!=null){

                return response([
                    'success' => false,
                    'message' => 'There is Already a User with This Email.'
                ], 200);

            }

            if (!$user) {
                $last_name = $request->last_name;

                $user = User::create([
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'email' => $email,
                    'password' => Hash::make($password),
                ]);   

                $business_card = BusinessCard::where('user_id', $user->id)->first();

                if (!$business_card) {
                    $business_card = BusinessCard::create(['business_name' => $first_name . ' ' . $last_name,
                        'email' => $email,
                        'user_id' => $user->id
                    ]);
                }
            } else {
                $updated_first_name_or_last_name = false;

                if ($user->first_name != $first_name) {
                    $user->first_name = $first_name;
                    $updated_first_name_or_last_name = true;
                }

                if ($user->last_name != $last_name) {
                    $user->last_name = $last_name;
                    $updated_first_name_or_last_name = true;
                }

                
                
                if ($updated_first_name_or_last_name) {
                    $user->password=Hash::make($password);
                    $user->save();
                    $business_card = BusinessCard::where('user_id', $user->id)->first();
                    $business_name = $user->first_name . ' ' . $user->last_name;
                    $business_card->business_name = $business_name;
                    $business_card->save();
                }else{
                    $user->password=Hash::make($password);
                    $user->save();
                }
            }

            $token = $user->createToken($email)->plainTextToken;

            $business_card = $user->business_card()->first();

            $data = [];

            $data['user'] = $user;

            $data['business_card'] = $business_card;

            $data['token'] = $token;

            return response([
                'message' => 'Access Token',
                'success' => true,
                'data' => $data
            ], 200);
        
    } catch (Exception $e) {
        return response([
            'success' => false,
            'message' => $e->getMessage(),
        ], 200);
    }

    }

    public function login(Request $request){
        try {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password)){
            return response([
                'success' => false,
                'message' => 'The provided credentials are incorrect as User.'
           ], 200);
        }

        $token = $user->createToken($request->email)->plainTextToken;

        $business_card = $user->business_card()->first();

            $data = [];

            $data['user'] = $user;

            $data['business_card'] = $business_card;

            $data['token'] = $token;

            return response([
                'message' => 'Access Token',
                'success' => true,
                'data' => $data
            ], 200);

        } catch (Exception $e) {
            return response([
                'success' => false,
                'message' => $e->getMessage(),
            ], 200);
        }

    }

    

}

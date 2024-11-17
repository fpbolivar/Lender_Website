<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BusinessCardController extends Controller
{
    public function getBusinessCard(){
        try {

            $user =auth('user')->user();
            
            $business_card= $user->business_card;

            $data=[];

            $data['business_card']=$business_card;
              
            return response()->json([
                'message'=>'Business Card',
                'data'=>$data,
                'success'=>true,
            ], 200);
               
        } catch (\Exception $e) {
            // Exception handling
            return response()->json([
                'success'=>false,
                'message' => $e->getMessage()
            ], 200);
        }
    
    }

    public static function updateBusinessCard( Request $request)
    {

        try {

        $validator = Validator::make($request->all(), [
            'business_name' => 'nullable|string|max:40',
            'phone_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:50',
            'business_address' => 'nullable|string|max:50',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'success'=>false,
                'message' => $validator->errors(),
            ], 200); // Unprocessable Entity
        }


        $business_name=$request->business_name;
        $phone_number=$request->phone_number;
        $email=$request->email;
        $business_address=$request->business_address;


        $user =auth('user')->user();
            
        $business_card= $user->business_card;

        $business_card->business_name=$business_name;
        $business_card->phone_number=$phone_number;
        $business_card->email=$email;
        $business_card->business_address=$business_address;

        $business_card=$business_card->save();

        $data=[];

        if($business_card){

            $data['business_card']=$user->business_card;

            return response([
                'message'=>'Business Card is Updated',
                'success' => true,
                'data' =>$data
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

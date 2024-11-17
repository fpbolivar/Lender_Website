<?php

namespace App\Http\Controllers;

use App\Models\TransactionInformation;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class TransactionInformationController extends Controller
{
    public static function get_current_date(){
    return Carbon::now()->format('Y-m-d');
    }

    public function getTransactionInformation(){
        try {

            $user =auth('user')->user();

            $transaction_informations= $user->transaction_informations()->orderBy('id', 'desc')->get();

            $total_take_money=0;
            $total_give_money=0;

            foreach ($transaction_informations as $transaction_information )
            {
                $take_money=$transaction_information->take_money;
                $return_take_money=$transaction_information->return_take_money;
                $take_money=$take_money-$return_take_money;
                $total_take_money=$total_take_money+$take_money;

                $give_money=$transaction_information->give_money;
                $received_give_money=$transaction_information->received_give_money;
                $give_money=$give_money-$received_give_money;
                $total_give_money=$total_give_money+$give_money;
            }

            $total=['total_take_money'=>$total_take_money,'total_give_money'=>$total_give_money];

            $data=[];

            $data['transaction_informations']=$transaction_informations;

            $data['total_money']=$total;

            return response()->json([
                'message'=>'Transaction Information',
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

    public static function takeMoney( Request $request)
    {

        try {

            $validator = Validator::make($request->all(), [
                'customer_name' => 'required|string|max:30',
                'take_money' => 'required|numeric|digits_between:1,20',
                'phone_number' => 'required|string|max:20',
                'note' => 'nullable|string|max:255',
                'date' => 'required|date',
            ]);


            if ($validator->fails()) {
                return response()->json([
                    'success'=>false,
                    'message' => $validator->errors(),
                ], 200); // Unprocessable Entity
            }

            $customer_name=$request->customer_name;
            $take_money=$request->take_money;
            $phone_number=$request->phone_number;
            $note=$request->note;
            $date=$request->date;

            $user_id=$user =auth('user')->user()->id;

            $transaction_information=TransactionInformation::create([
                'customer_name'=>$customer_name,
                'take_money'=>$take_money,
                'phone_number'=>$phone_number,
                'note'=>$note,
                'date'=>$date,
                'user_id'=>$user_id
            ]);

            $transaction_detail=TransactionDetail::create([
                'take_money'=>$transaction_information->take_money,
                'date'=>$transaction_information->date,
                'transaction_id'=>$transaction_information->id,
            ]);

            $data=[];

            if($transaction_information){

                $data['transaction_information']=$transaction_information;

                return response([
                    'message'=>'Record is Inserted Successfully',
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

    public static function giveMoney( Request $request)
    {

        try {

            $validator = Validator::make($request->all(), [
                'customer_name' => 'required|string|max:30',
                'give_money' => 'required|numeric|digits_between:1,20',
                'phone_number' => 'required|string|max:20',
                'note' => 'nullable|string|max:255',
                'date' => 'required|date',
            ]);


            if ($validator->fails()) {
                return response()->json([
                    'success'=>false,
                    'message' => $validator->errors(),
                ], 200); // Unprocessable Entity
            }

            $customer_name=$request->customer_name;
            $give_money=$request->give_money;
            $phone_number=$request->phone_number;
            $note=$request->note;
            $date=$request->date;

            $user_id=$user =auth('user')->user()->id;

            $transaction_information=TransactionInformation::create([
                'customer_name'=>$customer_name,
                'give_money'=>$give_money,
                'phone_number'=>$phone_number,
                'note'=>$note,
                'date'=>$date,
                'user_id'=>$user_id
            ]);

            $transaction_detail=TransactionDetail::create([
                'give_money'=>$transaction_information->give_money,
                'date'=>$transaction_information->date,
                'transaction_id'=>$transaction_information->id,
            ]);

            $data=[];

            if($transaction_information){

                $data['transaction_information']=$transaction_information;

                return response([
                    'message'=>'Record is Inserted Successfully',
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

    public static function updateTakeMoney( Request $request)
    {

        try {

            $validator = Validator::make($request->all(), [
                'return_take_money' => 'required|numeric|digits_between:1,20',
                'transaction_information_id' => 'required|numeric',
            ]);


            if ($validator->fails()) {
                return response()->json([
                    'success'=>false,
                    'message' => $validator->errors(),
                ], 200); // Unprocessable Entity
            }

            $user_id=$user =auth('user')->user()->id;

            $return_take_money=$request->return_take_money;
            $transaction_information_id=$request->transaction_information_id;

            $transaction_information=TransactionInformation::find($transaction_information_id);

            if($transaction_information){

                if($user_id!=$transaction_information->user_id){

                    return response([
                        'success' => false,
                        'message' =>'You Are Not Able to Update Transaction Information'
                    ], 200);

                }else{

                    if($transaction_information->return_take_money>0){
                        $return_take_money_=$transaction_information->return_take_money;
                        $return_take_money=$return_take_money_+$return_take_money;
                    }

                    $transaction_information->return_take_money=$return_take_money;

                    $$transaction_information=$transaction_information->save();

                    $transaction_detail=TransactionDetail::create([
                        'return_take_money'=>$request->return_take_money,
                        'date'=>self::get_current_date(),
                        'transaction_id'=>$transaction_information_id,
                    ]);

                    if($transaction_information){

                        return response([
                            'success' => true,
                            'message' => 'Transaction Information is Successfully Updated'
                        ], 200);

                    }

                }

            }else{
                return response([
                    'success' => false,
                    'message' =>'Not Found Any Transaction Information With Id '.$transaction_information_id
                ], 200);
            }

        } catch (Exception $e) {
            return response([
                'success' => false,
                'message' => $e->getMessage(),
            ], 200);
        }
    }

    public static function updateGiveMoney( Request $request)
    {

        try {

            $validator = Validator::make($request->all(), [
                'received_give_money' => 'required|numeric|digits_between:1,20',
                'transaction_information_id' => 'required|numeric',
            ]);


            if ($validator->fails()) {
                return response()->json([
                    'success'=>false,
                    'message' => $validator->errors(),
                ], 200); // Unprocessable Entity
            }

            $user_id=$user =auth('user')->user()->id;

            $received_give_money=$request->received_give_money;
            $transaction_information_id=$request->transaction_information_id;

            $transaction_information=TransactionInformation::find($transaction_information_id);

            if($transaction_information){

                if($user_id!=$transaction_information->user_id){

                    return response([
                        'success' => false,
                        'message' =>'You Are Not Able to Update Transaction Information'
                    ], 200);

                }else{

                    if($transaction_information->received_give_money>0){
                        $received_give_money_=$transaction_information->received_give_money;
                        $received_give_money=$received_give_money_+$received_give_money;
                    }

                    $transaction_information->received_give_money=$received_give_money;
                    $$transaction_information=$transaction_information->save();

                    $transaction_detail=TransactionDetail::create([
                        'received_give_money'=>$request->received_give_money,
                        'date'=>self::get_current_date(),
                        'transaction_id'=>$transaction_information_id,
                    ]);


                    if($transaction_information){

                        return response([
                            'success' => true,
                            'message' => 'Transaction Information is Successfully Updated'
                        ], 200);

                    }

                }

            }else{
                return response([
                    'success' => false,
                    'message' =>'Not Found Any Transaction Information With Id '.$transaction_information_id
                ], 200);
            }

        } catch (Exception $e) {
            return response([
                'success' => false,
                'message' => $e->getMessage(),
            ], 200);
        }
    }

    public function getUniqueCustomersName(){
        try {

            $user =auth('user')->user();

            $transaction_informations= $transaction_informations= $user->transaction_informations()->orderBy('customer_name', 'asc')->select('customer_name')->distinct()->get();

            $customer_names=[];

            foreach ($transaction_informations as $transaction_information) {
                array_push($customer_names,$transaction_information->customer_name);
            }

            $data=[];

            $data['customer_names']=$customer_names;

            return response()->json([
                'message'=>'Customer Names',
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

    public function getReportOfTransactionInformation(Request $request){
        try {

            $validator = Validator::make($request->all(), [
                'from_date' => 'nullable|date',
                'to_date' => 'nullable|date',
                'all_money'=>'nullable|string|max:10',
                'take_money'=>'nullable|string|max:10',
                'give_money'=>'nullable|string|max:10',
                'name_or_amount'=>'nullable|string|max:50',
                'order_by_select_box'=>'nullable|string|max:50'
            ]);


            $from_date=$request->from_date;
            $to_date=$request->to_date;
            $all_money=$request->all_money;
            $take_money=$request->take_money;
            $give_money=$request->give_money;
            $name_or_amount=$request->name_or_amount;
            $order_by_select_box=$request->order_by_select_box;

            if ($validator->fails()) {
                return response()->json([
                    'success'=>false,
                    'message' => $validator->errors(),
                ], 200); // Unprocessable Entity
            }


//            dd($from_date.' '.$to_date.' '.$all_money.' '. $take_money.' '.$give_money.' '.$name_or_amount.' '.$order_by_select_box);

            $user =auth('user')->user();

            $transaction_informations= $user->transaction_informations();

            if($from_date){
                $transaction_informations=$transaction_informations->where('date','>=',$from_date);
            }

            if($to_date){
                $transaction_informations=$transaction_informations->where('date','<=',$to_date);
            }


            if(($take_money=='true' && $give_money=='true') || $all_money=='true'){

            }
            else {
                if ($take_money == 'true') {
                    $transaction_informations = $transaction_informations->where('take_money', '!=', 0);
                } elseif ($give_money == 'true') {
                    $transaction_informations = $transaction_informations->where('give_money', '!=', 0);
                }
            }

            if($name_or_amount){
                $transaction_informations=$transaction_informations->where(function ($query) use ($name_or_amount) {
                    $query->where('customer_name','like', '%'.$name_or_amount.'%')
                        ->orWhere('take_money', 'like', '%'.$name_or_amount.'%')
                        ->orWhere('give_money', 'like', '%'.$name_or_amount.'%');
                });
            }

            if($order_by_select_box=='amount_high_to_low'){
                if(($take_money=='true' && $give_money=='true') || $all_money=='true'){

                }else{
                    if ($take_money == 'true') {
                        $transaction_informations = $transaction_informations->orderBy('take_money', 'desc');
                    } elseif ($give_money == 'true') {
                        $transaction_informations = $transaction_informations->orderBy('give_money', 'desc');
                    }
                }
            }

            elseif($order_by_select_box=='time_latest_to_first'){
                $transaction_informations = $transaction_informations->orderBy('date', 'desc');
            }

            elseif($order_by_select_box=='time_oldest_to_first'){
                $transaction_informations = $transaction_informations->orderBy('date', 'asc');
            }

            elseif($order_by_select_box=='name_a_to_z'){
                $transaction_informations = $transaction_informations->orderBy('customer_name', 'asc');
            }
            else{
                $transaction_informations = $transaction_informations->orderBy('id', 'desc');
            }

            $transaction_informations=$transaction_informations->get();

            $total_take_money=0;
            $total_give_money=0;

            foreach ($transaction_informations as $transaction_information )
            {
                $take_money=$transaction_information->take_money;
                $return_take_money=$transaction_information->return_take_money;
                $take_money=$take_money-$return_take_money;
                $total_take_money=$total_take_money+$take_money;

                $give_money=$transaction_information->give_money;
                $received_give_money=$transaction_information->received_give_money;
                $give_money=$give_money-$received_give_money;
                $total_give_money=$total_give_money+$give_money;
            }

            $total=['total_take_money'=>$total_take_money,'total_give_money'=>$total_give_money];

            $data=[];

            $data['transaction_informations']=$transaction_informations;

            $data['total_money']=$total;

            $data['order_by_select_box']=['amount_high_to_low','time_latest_to_first','time_oldest_to_first','name_a_to_z'];

            return response()->json([
                'message'=>'Transaction Information',
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


    public static function deleteSingleTransactionInformation( Request $request)
    {

        try {

            $validator = Validator::make($request->all(), [
                'transaction_information_id' => 'required|numeric',
            ]);


            if ($validator->fails()) {
                return response()->json([
                    'success'=>false,
                    'message' => $validator->errors(),
                ], 200); // Unprocessable Entity
            }

            $user_id=$user =auth('user')->user()->id;

            $transaction_information_id=$request->transaction_information_id;

            $transaction_information=TransactionInformation::find($transaction_information_id);

            if($transaction_information){

                if($user_id!=$transaction_information->user_id){

                    return response([
                        'success' => false,
                        'message' =>'You Are Not Able to Delete Transaction Information'
                    ], 200);

                }else{

                    $transaction_information=$transaction_information->delete();

                    if($transaction_information){

                        return response([
                            'success' => true,
                            'message' => 'Transaction Information is Successfully Deleted'
                        ], 200);

                    }

                }

            }else{
                return response([
                    'success' => false,
                    'message' =>'Not Found Any Transaction Information With Id '.$transaction_information_id
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

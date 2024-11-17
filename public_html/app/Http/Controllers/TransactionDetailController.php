<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\TransactionInformation;
use App\Models\TransactionDetail;

class TransactionDetailController extends Controller
{
    public function getTransactionDetails(Request $request){
        try {

            $validator = Validator::make($request->all(), [
                'from_date' => 'nullable|date',
                'to_date' => 'nullable|date',
                'money_amount'=>'nullable|string|max:10',
                'transaction_id' => 'required|numeric',
            ]);


            $from_date=$request->from_date;
            $to_date=$request->to_date;
            $money_amount=$request->money_amount;
            $transaction_id=$request->transaction_id;


            if ($validator->fails()) {
                return response()->json([
                    'success'=>false,
                    'message' => $validator->errors(),
                ], 200); // Unprocessable Entity
            }


//            dd($from_date.' '.$to_date.' '.$all_money.' '. $take_money.' '.$give_money.' '.$name_or_amount.' '.$order_by_select_box);

            $user_id=auth('user')->user()->id;
            
            $transaction_information=TransactionInformation::find($transaction_id);

            if($transaction_information){

                if($user_id!=$transaction_information->user_id){

                    return response([
                        'success' => false,
                        'message' =>'You Are Not Able to Get Transaction Detail of Transaction Information With Id '.$transaction_id
                    ], 200);

                }
            }
            $transaction_details=TransactionDetail::where('transaction_id',$transaction_id);

            if($from_date){
                $transaction_details=$transaction_details->where('date','>=',$from_date);
            }

            if($to_date){
                $transaction_details=$transaction_details->where('date','<=',$to_date);
            }

            if($money_amount){
                $transaction_details=$transaction_details->where(function ($query) use ($money_amount) {
                    $query->where('take_money','like', '%'.$money_amount.'%')
                        ->orWhere('return_take_money', 'like', '%'.$money_amount.'%')
                        ->orWhere('give_money', 'like', '%'.$money_amount.'%')
                        ->orWhere('received_give_money', 'like', '%'.$money_amount.'%');
                });
            }

            $transaction_details = $transaction_details
            ->orderBy('id', 'desc')
            ->get();

            $data=[];

            $data['transaction_details']=$transaction_details;

            return response()->json([
                'message'=>'Transaction Details',
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

}

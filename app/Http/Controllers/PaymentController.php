<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Stripe;
use Session;
use Stripe\Stripe as StripeStripe;

class PaymentController extends Controller
{
    //

    static function stripePayment($request){
        $stripe_get = PaymentMethod::select('key_id','key_secret')
        ->where('name','stripe')
        ->orWhere('name','Stripe')
        ->first();
        $key = $stripe_get->key_id;
        $key_secret = $stripe_get->key_secret;
        try {

            // dd(env('STRIPE_SECRET'),$request->all());
            $stripe = Stripe\Stripe::$clientId = $key;
            $stripe = new Stripe\StripeClient(
                $key_secret
              );
              $token = $stripe->tokens->create([
                'card' => [
                  'number' => $request["card_no"],
                  'exp_month' =>  $request["exp_month"],
                  'exp_year' => $request["exp_year"],
                  'cvc' => $request["cvv"],
                ],
              ]);

            //  dd('tets',$request->all(),$token);

               if (!isset($token['id'])) {

                   return response()->json([

                     'cart_details' => 'Token is not generate correct',
                     'status' => false

           ]);
               }

               

            //    $data['amount']= (float)$request->amount*100;
            //   dd($token['id']);
            
            //to save data
            $description = "You have made transfer of ".$request["amount"];
              $caharges =  $stripe->charges->create([
                'amount' => (int)$request["amount"]*100,
                'currency' => 'AUD',
                'source' => 'tok_mastercard',
                'description' => $description,
              ]);
            //     // dd((float)$request->amount * (float)$currencyRate->rate);
            //   $data = ['currency_rate_id' =>$currencyRate->id ,	'payment_gateway_id'=>$PaymentGateway->id,	'sender_id' =>$request->sender_id   ,	'payer_id' =>$request->reciever_id ?? null	,'amount'=>(float)$request->amount,	'status'=>4,	'desription'=>$description ,'reciever_amount'=>(int)$request->amount * (int)$currencyRate->rate,	'file' => "..."
            //    ];
            //    $payment = new Payment();
            //    $payment = $payment->saveData($data);
               // dd('test');
// 'currency_rate_id',	'payment_gateway_id',	'sender_id',	'payer_id'	,'amount',	'status',	'desription',	'file'

                      $payment = [
                        "amount" => $caharges->amount/100,
                        "key_id" => $key,
                        "key_secret" => $key_secret
                      ];
                       return response()->json([
                        // 'payment' => $payment['Activites'],
                        // 'cart_details' => 'Payment success',
                        'status' => true,
                        'payment' => $payment,
                       ]);




               }catch (\Exception $e) {
			// $description = "You transaction of ".$request->amount.' has been failed';
			
            //     $data = ['currency_rate_id' =>$currencyRate->id ,	'payment_gateway_id'=>$PaymentGateway->id,	'sender_id' =>$request->sender_id   ,	'payer_id' =>$request->reciever_id ?? null	,'amount'=>(float)$request->amount,	'status'=>2,	'desription'=>$description ,'reciever_amount'=>(int)$request->amount * (int)$currencyRate->rate,	'file' => "..."
            //    ];
            //     $payment = new Payment();
            //     $payment->saveData($data);
                   return response()->json([

                     'cart_details' => 'Error! '.$e->getMessage(),
                     'status' => false

                       ]);
               }

    }
}

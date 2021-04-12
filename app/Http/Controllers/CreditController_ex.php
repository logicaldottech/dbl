<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Credit;
use App\User;
use App\Download;
use App\Contact;
use App\CreditTransaction;

use Redirect,Response,DB,Config;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailNotify;
use App\MerchantOne\MerchantDirect;

class CreditController extends Controller

{
    public function index(Request $request){

      $user_id = Auth::user()->id;
      $user = User::with('credit')->find($user_id);

    	return view('credits/index',['user' => $user,'credits' => $user['credit']]);
    }



    public function exportByCompany(Request $request){

          $user_id = Auth::user()->id;
          $user = User::with('credit')->find($user_id);
          $get_id = $request->id;

          $method = 'custom_downloads';

          if ($method=="custom_downloads") {

            $lead_id_from = 1;
            $lead_id_to = 3;

            $contact = Contact::whereBetween('lead_id', array($lead_id_from, $lead_id_to))
                      ->get('id');

          }else {

            if (!is_array($get_id)) {
              $lead_id[] = $get_id;
            }else{
              $lead_id  = $get_id;
            }

            $contact = Contact::whereIn('lead_id', $lead_id)->get('id');
          }

          $count = count($contact);

          foreach ($contact as $key => $value) {
            $contact_id[] = $value->id;
          }

          // return response()->json($contact_id);

          if ($user->credit->balance >= $count) {

            $search['contact_id'] = $contact_id;
            $search['exportBy'] = "company";
            $search = json_encode($search);
            $deduct = $count;
            $type = "excel";
            // return response()->json($type);

            $downloads = $this->downloads($search, $user_id, $deduct, $type);
            // return response()->json($downloads);

            if ($downloads === true ) {

              $debit = $this->debit($user_id, $count);

              return response()->json(true);

            }

          }
          return response()->json(false);

    }
    // export credit by contacts
    public function exportByContacts(Request $request){

      $user_id = Auth::user()->id;
      $user = User::with('credit')->find($user_id);


          // $get_id = $request->id;
        $method = 'custom_downloads';

        if ($method=="custom_downloads") {
          $contact_id_from = 12;
          $contact_id_to = 16;

          $contact = Contact::whereBetween('id', array($contact_id_from, $contact_id_to))
                    ->get('id');

          foreach ($contact as $key => $value) {
            $contact_id[] = $value->id;
          }

        }else {

          if (!is_array($get_id)) {
            $contact_id[] = $get_id;
          }else{
            $contact_id  = $get_id;
          }

        }
          //end if

          $count = count($contact_id);

          if ($user->credit->balance >= $count) {

            $search['contact_id'] = $contact_id;
            $search['exportBy'] = "contacts";
            $search = json_encode($search);
            $deduct = $count;
            $type = "excel";
            // return response()->json($type);

            $downloads = $this->downloads($search, $user_id, $deduct, $type);
            // return response()->json($downloads);

            if ($downloads === true ) {

              $debit = $this->debit($user_id, $count);

              return response()->json(true);

            }

          }

          return response()->json(false);

  }
    //end export credit by contacts

    //download
    public function downloads($search, $user_id, $deduct, $type){

      $check = Download::where('leads', '=', $search)
              ->where('user_id', '=', $user_id)
              ->get('id');
      // return response()->json($check);

      if ($check->isEmpty()) {

        $downloadArray = array(
              'user_id'  => $user_id,
              'leads'  => $search,
              'credit'  => $deduct,
              'type'  => $type,
          );

          $download = Download::create($downloadArray);

          return true;
      }

        return true;
    }

    // debit
    public function debit($user_id, $count){

      $user = User::with('credit')->find($user_id);

     $type = "debit";

     $action = "download";
      // echo $user->credit->balance;die;
     $credit = Credit::find($user->credit->id);

     $amount = $count;

     $credit->balance = $credit->balance - $amount;

     $credit->save();

     $balance = $credit->balance;
     $transactionArray = array(

         'user_id'      => $user_id,
         'transactions' => $amount,
         'action'       => $action,
         'type'         => $type,
         'balance'      => $balance
       );

       $transaction = CreditTransaction::create($transactionArray);
       if(!is_null($transaction)) {

         return true;
       }else{
         return false;
       }

    }

    public function purchase(){

      $user_id = Auth::user()->id;
      $user = User::with('credit')->find($user_id);
      $discount_data = $this->get_discount_level();

      return view('credits/purchase',['user' => $user,'credits' => $user['credit'],
      'discount_data' => $discount_data]);

    }





    public function add_credit( $creditstoadd ){

      $user_id = Auth::user()->id;
      $user = User::with('credit')->find($user_id);

      $user_credit = Credit::find($user->credit->id);

  		$old_balanace = $user_credit->balance;

  		$user_credit->balance = $old_balanace + $creditstoadd;

  		$result = $user_credit->save();

      return $result;


    }


    public function get_discount_level(){

      $user_id = Auth::user()->id;
      $total_credits_purchased = DB::table('transaction_successful')->where('user_id',$user_id)->sum('credits');

      if ( $total_credits_purchased <= 500 ){
        $level = "Standard";
        $price = 1.00;
        $discount = "0%";
      } elseif ( $total_credits_purchased >= 501 && $total_credits_purchased <= 1000 ) {
        $level = "Bronze";
        $price = 0.91;
        $discount = "9%";
      } elseif ( $total_credits_purchased >= 1001 && $total_credits_purchased <= 2000 ) {
        // code...
        $level = "Silver";
        $price =  0.79;
        $discount = "21%";
      } elseif ( $total_credits_purchased >= 2001 && $total_credits_purchased <= 5000 ) {
        // code...
        $level = "Gold";
        $price = 0.67;
        $discount = "33%";
      } else {
        $level = "Platinum";
        $price = 0.50;
        $discount = "50%";
      }


      return array(
        'level' => $level,
        'price' => $price,
        'discount' => $discount,
        'total_credits_purchased' => $total_credits_purchased
      );


    }
    public function get_price_per_credit(){

      $discount = $this->get_discount_level();
      return $discount['price'];

    }

    public function total_credits_purchased($user_id){

      $result = DB::table('transaction_successful')->where('user_id',$user_id)->sum('credits');

      return $result;

    }

    public function proceedpayment(Request $request){


      $user_id = Auth::user()->id;
      $user = User::find($user_id);


      $numberofcredits = (int)$request->credits;

      $price_per_credit = $this->get_price_per_credit();

      $total_price = $numberofcredits * $price_per_credit;

       $gw = new MerchantDirect;
      //
      $gw->setLogin("br2c9XQgqVFP9VRxJ42h6z5Zk7q5FRwh");
      //
      $gw->setBilling($user->first_name,$user->last_name,$user->email);

      $apiresult = $gw->doSale($total_price,$request->number,$request->expiry,$request->cvv);

      $responsecode = (int)$apiresult['response'];
      if ( $responsecode === 1 ){
        $add_credit = $this->add_credit($numberofcredits);
        if ( $add_credit ){
          DB::table('transaction_successful')->insert(
              [
              'transaction_id' => (int)$apiresult['transactionid'],
               'credits' => $numberofcredits,
               'amount'  => $total_price,
               'user_id' => $user_id
              ]
          );
        } else {
          $tempresponse = "Transaction ID is " . $apiresult['transactionid'] . ". Failed
          due to credits addition. Amount was " . $total_price;

          DB::table('transaction_failed')->insert(
           [
            'user_id'  => $user_id,
            'response' => json_encode($tempresponse)
           ]
        );

        }
      } else {

        DB::table('transaction_failed')->insert(
            [
             'user_id'  => $user_id,
             'response' => json_encode($apiresult)
            ]
        );
      }
      return response()->json($apiresult);

    }
}

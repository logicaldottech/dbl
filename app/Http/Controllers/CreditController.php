<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Credit;
use App\User;
use App\Lead;
use App\Download;
use App\Contact;
use App\CreditTransaction;

use Redirect,Response,DB,Config;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailNotify;
use App\Mail\MailDebit;
use App\MerchantOne\MerchantDirect;

class CreditController extends Controller

{
    public function index(Request $request){

      $user_id = Auth::user()->id;
      $user = User::with('credit')->find($user_id);

    	return view('credits/index',['user' => $user,'credits' => $user['credit']]);
    }

    public function userWithCredit(Request $request){

      $user_id = Auth::user()->id;
      $user = User::with('credit')->find($user_id);

      return response()->json($user);

    }

    public function exportByCompany(Request $request){

      $user_id = Auth::user()->id;
      $user = User::with('credit')->find($user_id);
      $email = $user->email;
      $get_id = $request->id;

      if (!is_array($get_id)) {
        $lead_id[] = $get_id;
      }else{
        $lead_id  = $get_id;
      }

      $contact = Contact::whereIn('lead_id', $lead_id)->get('id');

      $count = count($contact);

      foreach ($contact as $key => $value) {
        $contact_id[] = $value->id;
      }

      if ($user->credit->balance >= $count) {

        $search['contact_id'] = $contact_id;
        $search['exportBy'] = "company";
        $search = json_encode($search);
        $deduct = $count;
        $type = "excel";

        $downloads = $this->downloads($search, $user_id, $deduct, $type);

        if ($downloads === true ) {

          $debit = $this->debit($user_id, $count);

          $userWithCredit = User::with('credit')->find($user_id);

          Mail::to($email)->send(new MailDebit($userWithCredit, $deduct));

          return response()->json(true);

        }

      }
      return response()->json(false);

    }

    public function exportCustomByCompany(Request $request){

      $user_id = Auth::user()->id;
      $user = User::with('credit')->find($user_id);
      $email = $user->email;

      $get_id = $request->id;

      $lead_id_from = 1;
      $lead_id_to = 3;

      $contact = Contact::whereBetween('lead_id', array($lead_id_from, $lead_id_to))
                ->get('id');

      $count = count($contact);

      foreach ($contact as $key => $value) {
        $contact_id[] = $value->id;
      }

      if ($user->credit->balance >= $count) {

        $search['contact_id'] = $contact_id;
        $search['exportBy'] = "company";
        $search = json_encode($search);
        $deduct = $count;
        $type = "excel";

        $downloads = $this->downloads($search, $user_id, $deduct, $type);

        if ($downloads === true ) {

          $debit = $this->debit($user_id, $count);

          $userWithCredit = User::with('credit')->find($user_id);

          Mail::to($email)->send(new MailDebit($userWithCredit, $deduct));

          return response()->json(true);

        }

      }
      return response()->json(false);

    }

    // export credit by contacts
    public function exportByContacts(Request $request){

      $user_id = Auth::user()->id;
      $user = User::with('credit')->find($user_id);
      $email = $user->email;

      $get_id = $request->id;

      if (!is_array($get_id)) {
        $contact_id[] = $get_id;
      }else{
        $contact_id  = $get_id;
      }

      $count = count($contact_id);

      if ($user->credit->balance >= $count) {

        $search['contact_id'] = $contact_id;
        $search['exportBy'] = "contacts";
        $search = json_encode($search);
        $deduct = $count;
        $type = "excel";

        $downloads = $this->downloads($search, $user_id, $deduct, $type);

        if ($downloads === true ) {

          $debit = $this->debit($user_id, $count);

          $userWithCredit = User::with('credit')->find($user_id);

          Mail::to($email)->send(new MailDebit($userWithCredit, $deduct));

          return response()->json(true);

        }

      }

      return response()->json(false);

  }
    //end export credit by contacts

    public function exportCustomByContacts(Request $request){

      $user_id = Auth::user()->id;
      $user = User::with('credit')->find($user_id);
      $email = $user->email;

      $contact_id_from = $request->customFrom;
      $contact_id_to = $request->customTo;
      $deff = $contact_id_to-$contact_id_from+1;
      $searchParam = json_decode($request->search);

      $data = $this->search($searchParam);

      // $result= array_slice($data,0,4);

      foreach ($data as $key => $value) {
        $contact_id[] = $value->cid;
      }
      $result = array_slice($contact_id, $contact_id_from-1, $deff);

      // return response()->json($result);
      $count = count($result);

      if ($user->credit->balance >= $count) {

        $search['contact_id'] = $result;
        $search['exportBy'] = "contacts";
        $search = json_encode($search);
        $deduct = $count;
        $type = "excel";

        $downloads = $this->downloads($search, $user_id, $deduct, $type);

        if ($downloads === true ) {

          $debit = $this->debit($user_id, $count);

          $userWithCredit = User::with('credit')->find($user_id);

          Mail::to($email)->send(new MailDebit($userWithCredit, $deduct));

          return response()->json($result);

        }

      }

      return response()->json(false);

  }

  public function search($search){
    // return "dsfdss";

      // geek code start
      $leads = Lead::with(['naics_codes','psc_codes','business_types','countries','states','cities','zips','mail_countries','mail_states','mail_cities','mailZips','physicalStreets','mailingStreets','stateOfIncorpo','countryOfIncorpo'])
              ->join('contacts', function ($join) {
                    $join->on('leads.id', '=', 'contacts.lead_id');
                })
              ->select('contacts.id as cid',
               'contacts.email_address',
               'contacts.first_name',
               'contacts.last_name',
               'contacts.contact_phone',
               'contacts.contact_order',
               'leads.*');
        $data = [];

        $request = $search;
        // return $leads;

        // Filter NAICS code
        if (property_exists($request,'naics')) {

            $naics = $request->naics;

            if (!empty($naics)) {
              $leads = $leads->whereHas('naics_codes', function($query) use($naics) {
                  $query->WhereIn('code', $naics);
                  });
            }
            //end if

        }

        if ( property_exists($request,'psc')){

          $psc =$request->psc;

          if (!empty($psc)) {

          $leads = $leads->whereHas('psc_codes', function($query) use($psc) {
                  // $query->whereIn('psc_code', ['H212','F103']);
                  $query->WhereIn('psc_code', $psc);
                  });
          }
          //end if
          // return $request;
        }

        // Filter naics_industry
        if ( property_exists($request,'industry_name')) {

            $industries = $request->industry_name;

            if (!empty($industries)) {

              $leads = $leads->whereHas('naics_codes', function($query) use($industries) {
                  foreach( $industries as $k => $industry ){
                    if ( $k === 0 ){
                      $query->where('code', 'like', $industry.'%');
                    } else {
                      $query->orWhere('code', 'like', $industry.'%');

                    }

                  }

                  });
              }
              //end if
          }

          // business_type
          if (property_exists($request,'business_type')) {

              $business_type = $request->business_type;

              if (!empty($business_type)) {

                $leads = $leads->whereHas('business_types', function($query) use($business_type) {
                        // $query->whereIn('psc_code', ['H212','F103']);
                        $query->WhereIn('business_type', $business_type);
                        });
              }
              //end if
          }

          // filter Corporate URL
          if (property_exists($request,'url')) {

             $url = $request->url;

             if (!empty($url)) {

               $url = preg_replace(
                '#((https?|www|ftp|http)://www.(\S*?\.\S*?))([\s)\[\]{},;"\':<]|\.\s|$)#i',
                "$3",
                $url
              );
              $url = preg_replace(
               '#((https?|www|ftp|http)://(\S*?\.\S*?))([\s)\[\]{},;"\':<]|\.\s|$)#i',
               "$3",
               $url
             );
              $url = preg_replace(
               '#((www.)(\S*?\.\S*?))([\s)\[\]{},;"\':<]|\.\s|$)#i',
               "$3",
               $url
             );
              $leads = $leads->Where(function ($query) use($url) {
                       for ($i = 0; $i < count($url); $i++){
                         // $urlNew = parse_url($url[$i]);

                          $query->orwhere('corporate_url', 'like',  '%' . $url[$i] .'%');
                       }
                     });
            }
            //end if

          }

          // filter Legal Business Name
          if (property_exists($request,'business_name')) {

           $bName = $request->business_name;
           if (!empty($bName)) {

               $leads = $leads->WhereIn('legal_business_name', $bName);
           }
           // end if
          }

          // filter Legal DBA Name
          if (property_exists($request,'dba_name')) {

           $dba_name = $request->dba_name;
           if (!empty($dba_name)) {

               $leads = $leads->WhereIn('dba_name', $dba_name);
           }
           // end if
          }

          // filter Fiscal Year
          if (property_exists($request,'fiscal_year')) {

             $fiscal = $request->fiscal_year;

             if (!empty($fiscal)) {

                $from = (int)$fiscal['from'];
                $to = (int)$fiscal['to'];

                $leads = $leads->whereBetween('fiscal_year', [$from, $to]);
            }
            // end if
          }

          // Filter business_start_date
          if (property_exists($request,'business_start_date')) {

            $start_date = $request->business_start_date;

            if (!empty($start_date)) {

               $from = $start_date['from'];
               $to = $start_date['to'];

               $leads = $leads->whereBetween('business_start_date', [$from, $to]);
           }
           // end if
         }

 // filters physical address
         // Filter country
         if (property_exists($request,'country')) {

             $country = $request->country;
             if (!empty($country)) {

               $leads = $leads->whereHas('countries', function($query) use($country) {

                   $query->WhereIn('alpha_3', $country);
               });
             }
             // end if
         }

         // Filter state
         if (property_exists($request,'state')) {

             $state = $request->state;
             if (!empty($state)) {

               $leads = $leads->whereHas('states', function($query) use($state) {

                   $query->WhereIn('name', $state);
               });
             }
             // end if
         }

         // Filter city
         if (property_exists($request,'city')) {

             $city = $request->city;
             if (!empty($city)) {

               $leads = $leads->whereHas('cities', function($query) use($city) {
                   $query->WhereIn('name', $city);
                   });
              }
              //end if
        }

        // Filter zip
        if (property_exists($request,'zip')) {

         $zip = $request->zip;
         if (!empty($zip)) {

           $leads = $leads->whereHas('zips', function($query) use($zip) {
               $query->WhereIn('value', $zip);
               });
          }
          // end if
        }

        $leads = $leads->get();


        return $leads;

// geek code end

  }

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

<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LeadsExport;
use App\Exports\LeadsExportContact;
use App\Exports\LeadsExportAll;
use App\Exports\LeadsExportAllContact;

use Illuminate\Support\Facades\Mail;
use App\Mail\MailDebit;

Use App\BusinessType;
use App\Lead;
use App\Contact;
use App\Download;
use App\Credit;
use App\Debit;
use App\CreditTransaction;
use App\NaicsIndustry;
use Illuminate\Support\Collection;
// use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use App\Search;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class downloadController extends Controller
{

    public function export(Request $request)
    {



    	$ids = [];
      $ids = $request->ids;
      // var_dump($ids);

      return (new LeadsExport($ids))->download('leads.csv');

    }

    public function exportContacts(Request $request)
    {

      $contact_ids = $request->ids;
      // $lead_ids = $request->lead_ids;
      // var_dump($ids);
      return (new LeadsExportContact($contact_ids))->download('leads.csv');

    }


    public function exportall(Request $request)
    {


      $ids = [];

      $search = json_decode($request->search);

      $exportBy = "company";
      $data = $this->search($search);

      // print_r($data->toArray());die;
      	foreach ( $data as $id => $lead ){
          $lead_id[] = $lead->id;
        }

      $user_id = Auth::id();
      // var_dump($lead_id);die;
      $user = User::with('credit')->find($user_id);
      $email = $user->email;

      $contact = Contact::whereIn('lead_id', $lead_id)->get('id');
      $count = count($contact);

      foreach ($contact as $key => $value) {
        $contact_id[] = $value->id;
      }
      // echo $count;
      if ($user->credit->balance >= $count) {

        $leads_download['contact_id'] = $contact_id;
        $leads_download['exportBy'] = $exportBy;
        $leads_download = json_encode($leads_download);
        $deduct = $count;
        $type = "excel";
        // return response()->json($type);

        $downloads = $this->downloads($leads_download, $user_id, $deduct, $type);
        // return response()->json($downloads);

        if ($downloads === true ) {

          $debit = $this->debit($user_id, $count);

          $userWithCredit = User::with('credit')->find($user_id);

          Mail::to($email)->send(new MailDebit($userWithCredit, $deduct));

          return (new LeadsExportAll($data))->download('leads.csv');

        }

      }
      return redirect('/')->with('lesscredit', 'credit not enough');

    }


    public function exportallContacts(Request $request)
    {


      $ids = [];

      $search = json_decode($request->search);

      $exportBy = "contacts";
      $data = $this->search($search);

      // print_r($data->toArray());die;
      	foreach ( $data as $id => $lead ){
          $lead_id[] = $lead->id;
        }

      $user_id = Auth::id();
      // var_dump($lead_id);die;
      $user = User::with('credit')->find($user_id);
      $email = $user->email;

      $contact = Contact::whereIn('lead_id', $lead_id)->get('id');
      $count = count($contact);

      foreach ($contact as $key => $value) {
        $contact_id[] = $value->id;
      }
      // echo $count;
      if ($user->credit->balance >= $count) {

        $leads_download['contact_id'] = $contact_id;
        $leads_download['exportBy'] = $exportBy;
        $leads_download = json_encode($leads_download);
        $deduct = $count;
        $type = "excel";
        // return response()->json($type);

        $downloads = $this->downloads($leads_download, $user_id, $deduct, $type);
        // return response()->json($downloads);

        if ($downloads === true ) {

          $debit = $this->debit($user_id, $count);

          $userWithCredit = User::with('credit')->find($user_id);

          Mail::to($email)->send(new MailDebit($userWithCredit, $deduct));

          return (new LeadsExportAllContact($data, $contact_id))->download('leads.csv');

        }

      }
      return redirect('/')->with('lesscredit', 'credit not enough');

    }

    // $debit
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

    // download
    public function downloads($leads_download, $user_id, $deduct, $type){

      $check = Download::where('leads', '=', $leads_download)
                ->where('user_id', '=', $user_id)
                ->get('id');
      // return response()->json($check);

      if ($check->isEmpty()) {

        $downloadArray = array(
              'user_id'  => $user_id,
              'leads'  => $leads_download,
              'credit'  => $deduct,
              'type'  => $type,
          );

          $download = Download::create($downloadArray);

          return true;
      }

        return true;
    }


    public function search($search){

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

    public function getDownloads(){
      $user_id = Auth::id();
      $user = Auth::user();
      $search = User::find(1);
      // echo $search;
      $data = Download:: where('user_id', $user_id)->paginate(5);

      foreach ($data as $key => $value) {

          if ($value['type'] == "excel") {
            $data[$key]['type'] = "Excel";
          }

          $data[$key]['created_at'] = date("Y-m-d",strtotime($value['created_at']));

          $decode = json_decode($value['leads']);

          if (isset($decode->contact_id)) {

            $data[$key]['contact_id'] = json_decode($value['leads'])->contact_id;
            $data[$key]['contact_id'] = json_encode($data[$key]['contact_id']);

          }

          if (isset($decode->exportBy)) {

            $data[$key]['export_by'] = json_decode($value['leads'])->exportBy;

          }

          if ($data[$key]['export_by'] == "contacts") {
            $data[$key]['export_by'] = "Contacts Search";
          }

          if ($data[$key]['export_by'] == "company") {
            $data[$key]['export_by'] = "Company Search";
          }

      }
      // $data['paginate'] = array(
      //   'total' => $data->total(),
      //   'currentPage' => $data->currentPage(),
      // );
      // $data = $data->toArray();
      // print_r($data);die;
      // $data = $data->toArray()['data'];
      // var_dump($data->toArray()['data']);
      return view('pages/downloads', ['user' => $user, 'download_data' => $data]);
    }

    public function exportDownloads(Request $request){

      $ids = [];

      $ids = json_decode($request->ids);

      $contacts = Contact::whereIn("id", $ids)->get('lead_id')->toArray();
      // var_dump($contacts);die;
      foreach ($contacts as $key => $value) {
        $contact_id[] = $value['lead_id'];
      }
      $contact_id = array_unique($contact_id);

      return (new LeadsExport($contact_id))->download('leads.csv');

    }

    public function getContacts(Request $request){

      $contact = $request->contact;
      $contacts = DB::connection('mysql2')->table('contacts')
              ->leftJoin('leads', 'contacts.lead_id', '=', 'leads.id')
              ->leftJoin('naics_lead', 'leads.id', '=', 'naics_lead.lead_id')
              ->leftJoin('naics_codes', 'naics_lead.naics_code_id', '=', 'naics_codes.id')
              ->leftJoin('psc_lead', function ($join) {
                $join->on('leads.id', '=', 'psc_lead.lead_id');
                })
              // ->leftJoin('psc_codes', 'psc_lead.psc_code_id', '=', 'psc_codes.id')
              ->whereIn('contacts.id', $contact)
              ->get();
      // $contacts = Contact::with('psc_codes')->whereIn('id', $contact)->get();
      // $lead_id = $contact->lead->id;

      // foreach ($contacts as $key => $contact) {
      //   $lead_id[] = $contact->lead->id;
      //
      //   $leads = Lead::with('psc_codes')->whereIn('id',$lead_id)->get();
      // }
      return response()->json($contacts);

    }

}


?>

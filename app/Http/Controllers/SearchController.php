<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lead;
use App\Contact;
use App\NaicsCode;
use App\PscCode;
use App\PscDescription;
use App\NaicsIndustry;
use Illuminate\Support\Collection;
// use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailSavedSearch;
use Illuminate\Support\Arr;
use App\Search;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class SearchController extends Controller
{

    public function search(Request $request){

      $orderBy = "contacts.id";
      $orderKey = "asc";
      // Order By
      if ($request->orderBy && !empty($request->orderBy)) {

         $orderBy = $request->orderBy;

         if ($orderBy == "contacts") {

           $orderBy = "contacts.first_name";

         }
         elseif ($orderBy == "email") {

           $orderBy = "contacts.email_address";

         }
         elseif ($orderBy == "phone") {

           $orderBy = "contacts.contact_phone";

         }
         elseif ($orderBy == "legal_business_name") {

           $orderBy = "leads.legal_business_name";

         }
         elseif ($orderBy == "dba_name") {

           $orderBy = "leads.dba_name";

         }
         elseif ($orderBy == "url") {

           $orderBy = "leads.corporate_url";

         }
         elseif ($orderBy == "business_start_date") {

           $orderBy = "leads.business_start_date";

         }
         elseif ($orderBy == "fiscal_year") {

           $orderBy = "leads.fiscal_year";

         }
         elseif ($orderBy == "country") {

           $orderBy = "countries.alpha3";

         }

       } //end if order by main

       // order by ASC or DESC
       if ($request->orderKey && !empty($request->orderKey)) {

          $orderKey = $request->orderKey;

        }

        $leads = Lead::with(['naics_codes','psc_codes','business_types',
              'countries', 'states', 'cities', 'zips', 'mail_countries',
              'mail_states', 'mail_cities', 'mailZips'])
                ->join('contacts', function ($join) {
                      $join->on('leads.id', '=', 'contacts.lead_id');

                  })
                ->select('contacts.id as cid',
                 'contacts.email_address',
                 'contacts.first_name',
                 'contacts.last_name',
                 'contacts.contact_phone',
                 'contacts.contact_order',
                 'leads.*',
                 )
                 ->orderBy($orderBy, $orderKey);


          $data = [];

          // pagination dynamic
          if ($request->perPage && !empty($request->perPage)) {

             $perPage = $request->perPage;

         } else {
           $perPage = 10;

         }
         // pagination dynamic
         if ($request->page && !empty($request->page)) {

            $page = $request->page;

        } else {
          $page = 1;

        }

        // area code search
         if ( $request->area_code && !empty($request->area_code)){

           $area_code =$request->area_code;

           foreach ($area_code as $aKey => $area) {

              $leads = $leads->orWhere('contact_phone', 'like', $area . '%');
            }

         }// end if


         // psc search
          if ( $request->psc && !empty($request->psc)){

            $psc =$request->psc;

            $leads = $leads->whereHas('psc_codes', function($query) use($psc) {
                    $query->WhereIn('psc_code', $psc);
                    });
          }

          // psc description search
           // if ( $request->psc_description && !empty($request->psc_description)){
           //
           //   $psc_desc =$request->psc_description;
           //
           //   $leads = $leads->whereHas('psc_codes', function($query) use($psc) {
           //           $query->WhereIn('psc_code', $psc);
           //           });
           // }

          // Filter NAICS code
          if ($request->naics && !empty($request->naics)) {

              $naics = $request->naics;

              $leads = $leads->whereHas('naics_codes', function($query) use($naics) {
                  $query->WhereIn('code', $naics);
                  });

          }

          // Filter naics_industry
          if ($request->industry_name && !empty($request->industry_name)) {

              $industries = $request->industry_name;

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

          // Filter business_types
          if ($request->business_type && !empty($request->business_type)) {

              $business_type = $request->business_type;

              $leads = $leads->whereHas('business_types', function($query) use($business_type) {

                      $query->WhereIn('business_type', $business_type);
                      });

          }

          // filter Corporate URL
          if ($request->url && !empty($request->url)) {

             $url = $request->url;
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

                        $query->orwhere('corporate_url', 'like',  '%' . $url[$i] .'%');
                     }
                   });

          }

          // filter Legal Business Name
          if ($request->business_name && !empty($request->business_name)) {

             $bName = $request->business_name;

             $leads = $leads->WhereIn('legal_business_name', $bName);

          }

          // filter Legal DBA Name
          if ($request->dba_name && !empty($request->dba_name)) {

             $dba_name = $request->dba_name;

             $leads = $leads->WhereIn('dba_name', $dba_name);

          }

          // filter Fiscal Year
          if ($request->fiscal_year && !empty($request->fiscal_year)) {

             $fiscal = $request->fiscal_year;

              $from = (int)$fiscal['from'];
              $to = (int)$fiscal['to'];

              $leads = $leads->whereBetween('fiscal_year', [$from, $to]);

          }

           // Filter business_start_date
           if ($request->business_start_date && !empty($request->business_start_date)) {

             $start_date = $request->business_start_date;

              $from = $start_date['from'];
              $to = $start_date['to'];

              $leads = $leads->whereBetween('business_start_date', [$from, $to]);

          }


          $address = "physical";

      if ($address == "physical") {

  // filters physical address
          // Filter country
          if ($request->country && !empty($request->country)) {

              $country = $request->country;

              $leads = $leads->whereHas('countries', function($query) use($country) {

                  $query->WhereIn('alpha_3', $country);
              });

          }

          // Filter state
          if ($request->state && !empty($request->state)) {

              $state = $request->state;

              $leads = $leads->whereHas('states', function($query) use($state) {

                  $query->WhereIn('name', $state);
              });

          }

          // Filter city
          if ($request->city && !empty($request->city)) {

              $city = $request->city;
              $leads = $leads->whereHas('cities', function($query) use($city) {
                  $query->WhereIn('name', $city);
                  });
          }

          // Filter zip
           if ($request->zip && !empty($request->zip)) {

              $zip = $request->zip;
              $leads = $leads->whereHas('zips', function($query) use($zip) {
                  $query->WhereIn('value', $zip);
                  });

          }

          // Filter state of incorporation
          // if ($request->state_of_incorporation) {
          //
          //     $stateIncorpo = $request->state_of_incorporation;
          //     $leads = $leads->whereHas('stateOfIncorpo', function($query) use($stateIncorpo) {
          //         $query->WhereIn('name', $stateIncorpo);
          //         });
          //
          // }
          //
          // // Filter country of incorporation
          // if ($request->country_of_incorporation) {
          //
          //     $countryIncorpo = $request->country_of_incorporation;
          //     $leads = $leads->whereHas('countryOfIncorpo', function($query) use($countryIncorpo) {
          //         $query->WhereIn('alpha_3', $countryIncorpo);
          //         });
          //
          // }

      }else{

  // filters mailing address
          // Filter country
          if ($request->country && !empty($request->country)) {

              $country = $request->country;
              $leads = $leads->whereHas('mail_countries', function($query) use($country) {
                  $query->WhereIn('alpha_3', $country);
                  });

          }

          // Filter state
          if ($request->state && !empty($request->state)) {

              $state = $request->state;
              $leads = $leads->whereHas('mail_states', function($query) use($state) {
                  $query->WhereIn('name', $state);
                  });

          }

          // Filter city
          if ($request->city && !empty($request->city)) {

              $city = $request->city;
              $leads = $leads->whereHas('mail_cities', function($query) use($city) {
                  $query->WhereIn('name', $city);
                  });

          }

          // Filter zip
           if ($request->zip && !empty($request->zip)) {

              $zip = $request->zip;
              $leads = $leads->whereHas('mailZips', function($query) use($zip) {
                  $query->WhereIn('value', $zip);
                  });

          }

      }


          $leads = $leads->paginate($perPage,['*'], 'page', $page);

          foreach ( $leads as $lead ){

            $country = $state =$city = $zip = $mcountry = $mcity = $mstate = $mzip = "";
            //country
						if ($lead->countries->count()>0) {

							$country = $lead->countries->toArray()[0]['alpha_3'];

						}

						// state
						if ($lead->states->count()>0) {

							$state = $lead->states->toArray()[0]['name'];

						}

						// city
						if ($lead->cities->count()>0) {

							$city = $lead->cities->toArray()[0]['name'];

						}

						// zip
						if ($lead->zips->count()>0) {

							$zip = $lead->zips->toArray()[0]['value'];

						}

						// mail country
						if ($lead->mail_countries->count()>0) {

							$mcountry = $lead->mail_countries->toArray()[0]['alpha_3'];

						}

						// mail  state
						if ($lead->mail_states->count()>0) {

							$mstate = $lead->mail_states->toArray()[0]['name'];

						}

						// mail  city
						if ($lead->mail_cities->count()>0) {

							$mcity = $lead->mail_cities->toArray()[0]['name'];

						}

						// mail zips
						if ($lead->mailZips->count()>0) {

							$mzip = $lead->mailZips->toArray()[0]['value'];

						}
            // naics code
            $naics_code = Arr::flatten($lead->naics_codes->toArray());
            // $naicsFirstTwo = substr($naics_code[0], 0, 2);
            // $naicsFirstThree = substr($naics_code[0], 0, 3);
            // $naicsFirstFour = substr($naics_code[0], 0, 4);
            // $naicsFirstFive = substr($naics_code[0], 0, 5);
            //
            // $nIndustry = NaicsIndustry::OrWhere(function($q) use($naicsFirstTwo) {
            //                  $q->where('code', 'like', "$naicsFirstTwo%")
            //                    ->where('level', '=', 'Sectors');
            //              })
            //              ->OrWhere(function($q) use($naicsFirstThree) {
            //                   $q->where('code', 'like', "$naicsFirstThree%")
            //                     ->where('level', '=', 'Subsectors');
            //               })
            //               ->OrWhere(function($q) use($naicsFirstFour) {
            //                    $q->where('code', 'like', "$naicsFirstFour%")
            //                      ->where('level', '=', 'Industry Groups');
            //                })
            //                ->OrWhere(function($q) use($naicsFirstFive) {
            //                     $q->where('code', 'like', "$naicsFirstFive%")
            //                       ->where('level', '=', 'Industries');
            //                 })
            //               ->get()
            //               ->toArray();
            $industryCode = NaicsCode::whereIn('code', $naics_code)->get();

            if ($industryCode->count()>0) {

							$industryCode = $industryCode[0]->NaicsIndustries->toArray();

						}

            // psc description get
            $psc_code = Arr::flatten($lead->psc_codes->toArray());

            $pscDesc = PscCode::whereIn('psc_code', $psc_code)->get();

            if ($pscDesc->count()>0) {

							$pscDesc = $pscDesc[0]->psc_description->toArray();

						}

            // contact name
            $fname = $lead->first_name;

            $lname = '****';

            $full_name = $fname . " " . $lname;

            // contact email
            $contact_email = $lead->email_address;

            if (!empty($contact_email)) {

              $contact_email = strstr($contact_email, '@');
              $contact_email = '*****' . $contact_email;

            }

            // contact phone
            $contactPhone = $lead->contact_phone;

            if (!empty($contactPhone)) {
              $contactPhone = substr_replace($contactPhone, '*******', '3', '7');
            }

            $data['leads'][] = array(
              'lead_id'                 => $lead->id,
              'contact_id'                 => $lead->cid,
              'legal_business_name'     => $lead->legal_business_name,
              'dba_name'                => $lead->dba_name,
              'business_start_date'     => $lead->business_start_date,
              'url'                     => $lead->corporate_url,
              'fiscal_year'             => $lead->fiscal_year,
              'business_types'          => Arr::flatten($lead->business_types->toArray()),
              // 'naics_industry'          =>
              'naics_codes'             => $naics_code,
              'naics_industry'          => $industryCode,
              'psc_description'          => $pscDesc,
              'psc_codes'               => $psc_code,
              'business_types'          => Arr::flatten($lead->business_types->toArray()),
              'name'                    => $full_name,
              'email'                   => $contact_email,
              'contact_phone'           => $contactPhone,
              'contact_order'           => $lead->contact_order,
              'physical_countries'      => $country,
              'physical_state'          => $state,
              'physical_cities'         => $city,
              'physical_zips'           => $zip,
              //'state_of_incorporation'  => $lead->stateOfIncorpo->toArray(),
              //'country_of_incorporation'=> $lead->countryOfIncorpo->toArray(),
              // 'physical_streets'        => $lead->physicalStreets->toArray(),
              'mail_countries'          => $mcountry,
              'mail_states'             => $mstate,
              'mail_cities'             => $mcity,
              'mail_zips'                => $mzip,
              // 'mailing_streets'        => $lead->mailingStreets->toArray(),
            );

          }

            if ( $leads->total() === 0 ){
              $data['leads'] = array();
            }

            $data['paginate'] = array(
              'total'       => $leads->total(),
              'currentPage' => $leads->currentPage(),
              'lastPage'    => $leads->lastPage(),
              'lastPage'    => $leads->lastPage(),
              'perPage'     => $leads->perPage(),
              'hasPages'    => $leads->hasPages(),
              'as'          => $request->perPage
            );


          return response()->json($data);


    }
// end contact search

// start company search
    public function searchCompany(Request $request){

      $leads = Lead::with(['naics_codes','psc_codes','business_types',
            'countries', 'states', 'cities', 'zips', 'mail_countries',
            'mail_states', 'mail_cities', 'mailZips', 'contacts']);

        $data = [];

        if ( $request->psc && !empty($request->psc)){

          $psc =$request->psc;

          $leads = $leads->whereHas('psc_codes', function($query) use($psc) {
                  $query->WhereIn('psc_code', $psc);
                  });
        }

        // Filter NAICS code
        if ($request->naics && !empty($request->naics)) {

            $naics = $request->naics;

            $leads = $leads->whereHas('naics_codes', function($query) use($naics) {
                $query->WhereIn('code', $naics);
                });

        }

        // Filter naics_industry
        if ($request->industry_name && !empty($request->industry_name)) {

            $industries = $request->industry_name;

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

        // Filter business_types
        if ($request->business_type && !empty($request->business_type)) {

            $business_type = $request->business_type;

            $leads = $leads->whereHas('business_types', function($query) use($business_type) {

                    $query->WhereIn('business_type', $business_type);
                    });

        }

        // filter Corporate URL
        if ($request->url && !empty($request->url)) {

           $url = $request->url;
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

                      $query->orwhere('corporate_url', 'like',  '%' . $url[$i] .'%');
                   }
                 });

        }

        // filter Legal Business Name
        if ($request->business_name && !empty($request->business_name)) {

           $bName = $request->business_name;

           $leads = $leads->WhereIn('legal_business_name', $bName);

        }

        // filter Legal DBA Name
        if ($request->dba_name && !empty($request->dba_name)) {

           $dba_name = $request->dba_name;

           $leads = $leads->WhereIn('dba_name', $dba_name);

        }

        // filter Fiscal Year
        if ($request->fiscal_year && !empty($request->fiscal_year)) {

           $fiscal = $request->fiscal_year;

            $from = (int)$fiscal['from'];
            $to = (int)$fiscal['to'];

            $leads = $leads->whereBetween('fiscal_year', [$from, $to]);

        }

         // Filter business_start_date
         if ($request->business_start_date && !empty($request->business_start_date)) {

           $start_date = $request->business_start_date;

            $from = $start_date['from'];
            $to = $start_date['to'];

            $leads = $leads->whereBetween('business_start_date', [$from, $to]);

        }


        $address = "physical";

    if ($address == "physical") {

// filters physical address
        // Filter country
        if ($request->country && !empty($request->country)) {

            $country = $request->country;

            $leads = $leads->whereHas('countries', function($query) use($country) {

                $query->WhereIn('alpha_3', $country);
            });

        }

        // Filter state
        if ($request->state && !empty($request->state)) {

            $state = $request->state;

            $leads = $leads->whereHas('states', function($query) use($state) {

                $query->WhereIn('name', $state);
            });

        }

        // Filter city
        if ($request->city && !empty($request->city)) {

            $city = $request->city;
            $leads = $leads->whereHas('cities', function($query) use($city) {
                $query->WhereIn('name', $city);
                });
        }

        // Filter zip
         if ($request->zip && !empty($request->zip)) {

            $zip = $request->zip;
            $leads = $leads->whereHas('zips', function($query) use($zip) {
                $query->WhereIn('value', $zip);
                });

        }

    }else{

// filters mailing address
        // Filter country
        if ($request->country && !empty($request->country)) {

            $country = $request->country;
            $leads = $leads->whereHas('mail_countries', function($query) use($country) {
                $query->WhereIn('alpha_3', $country);
                });

        }

        // Filter state
        if ($request->state && !empty($request->state)) {

            $state = $request->state;
            $leads = $leads->whereHas('mail_states', function($query) use($state) {
                $query->WhereIn('name', $state);
                });

        }

        // Filter city
        if ($request->city && !empty($request->city)) {

            $city = $request->city;
            $leads = $leads->whereHas('mail_cities', function($query) use($city) {
                $query->WhereIn('name', $city);
                });

        }

        // Filter zip
         if ($request->zip && !empty($request->zip)) {

            $zip = $request->zip;
            $leads = $leads->whereHas('mailZips', function($query) use($zip) {
                $query->WhereIn('value', $zip);
                });


        }

    }


        $leads = $leads->paginate(10);
        foreach ( $leads as $lead ){

          $country = $state =$city = $zip = $mcountry = $mcity = $mstate = $mzip = "";
          //country
          if ($lead->countries->count()>0) {

            $country = $lead->countries->toArray()[0]['alpha_3'];

          }

          // state
          if ($lead->states->count()>0) {

            $state = $lead->states->toArray()[0]['name'];

          }

          // city
          if ($lead->cities->count()>0) {

            $city = $lead->cities->toArray()[0]['name'];

          }

          // zip
          if ($lead->zips->count()>0) {

            $zip = $lead->zips->toArray()[0]['value'];

          }

          // mail country
          if ($lead->mail_countries->count()>0) {

            $mcountry = $lead->mail_countries->toArray()[0]['alpha_3'];

          }

          // mail  state
          if ($lead->mail_states->count()>0) {

            $mstate = $lead->mail_states->toArray()[0]['name'];

          }

          // mail  city
          if ($lead->mail_cities->count()>0) {

            $mcity = $lead->mail_cities->toArray()[0]['name'];

          }

          // mail zips
          if ($lead->mailZips->count()>0) {

            $mzip = $lead->mailZips->toArray()[0]['value'];

          }

          $data['leads'][] = array(
            'lead_id'                 => $lead->id,
            'legal_business_name'     => $lead->legal_business_name,
            'dba_name'                => $lead->dba_name,
            'business_start_date'     => $lead->business_start_date,
            'url'                     => $lead->corporate_url,
            'fiscal_year'             => $lead->fiscal_year,
            'business_types'          => Arr::flatten($lead->business_types->toArray()),
            'naics_codes'             => Arr::flatten($lead->naics_codes->toArray()),
            'psc_codes'               => Arr::flatten($lead->psc_codes->toArray()),
            'business_types'          => Arr::flatten($lead->business_types->toArray()),
            'contacts'                => $lead->contacts->toArray(),
            'physical_countries'      => $country,
            'physical_state'          => $state,
            'physical_cities'         => $city,
            'physical_zips'           => $zip,
            'mail_countries'          => $mcountry,
            'mail_states'             => $mstate,
            'mail_cities'             => $mcity,
            'mail_zips'                => $mzip
          );

        }

          if ( $leads->total() === 0 ){
            $data['leads'] = array();
          }

          $data['paginate'] = array(
            'total' => $leads->total(),
            'currentPage' => $leads->currentPage(),
          );


        return response()->json($data);

    }
    //end company search

    public function saveSearch(Request $request){

      //geek code start
      if ($request->has('search_name')) {
        $search_name = $request->search_name;
      }

      if ($request->has('search')) {
        $searchData = json_encode($request->search);
      }

      $user = Auth::user();

      $email = $user->email;

      $user_id = $user->id;

      $searchArr = array(
          'user_id'  => $user_id,
          'name'  => $search_name,
          'search'  => $searchData
      );
      // return response()->json($searchData);

      $search = Search::create($searchArr);

      if (isset($search->id)) {

        //Mail::to($email)->send(new MailSavedSearch($user, $search));

        return response()->json(true);

      }
      return response()->json(false);

      // geek code end
    }

    public function getSearchLists(){

        $user_id = Auth::id();
        $search = User::find(1);
        // echo $search;
        $data = Search:: where('user_id', $user_id)->get();

        return response()->json($data);

    }

    public function getSearchSingle(Request $request){

      $search_id = $request->id;

      $data = Search:: where('id', $search_id)->get('search');

      $search = $data[0]->search;
      // $search = json_decode($search);
      return response()->json($search);

    }

    public function deleteSearchView(Request $request){

      $search_id = (int)$request->search_id;

      $user_id = Auth::id();

      $deleteSearch = Search::where('user_id', $user_id)
                      ->where('id', $search_id)
                      ->delete();

      if ($deleteSearch) {
        return response()->json(true);
      }
      return response()->json(false);

    }

}

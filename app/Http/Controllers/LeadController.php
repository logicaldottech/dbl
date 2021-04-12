<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lead;

use App\SicCode;
use App\PscCode;
use App\NaicsCode;
use App\Country;
use App\State;
use App\City;
use App\Zip;
use App\PhysicalAddress;
use App\PhysicalStreet;
use App\MailingAddress;
use App\MailingStreet;
use App\CompanyDivision;
use App\Contact;
use Illuminate\Support\Arr;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $leads = Lead::with(['naics_codes','psc_codes','business_types','contacts'])
                  ->paginate(10);
        $data = [];

        foreach ( $leads as $lead ){

          $data['leads'][] = array(
            'lead_id'                 => $lead->id,
            'legal_business_name'     => $lead->legal_business_name,
            'dba_name'                => $lead->dba_name,
            'business_start_date'     => $lead->business_start_date,
            //'employee_count'          => $lead->employee_count,
            'fiscal_year'             => $lead->fiscal_year,
          //  'annual_revenue'          => $lead->annual_revenue,
            'url'                     => $lead->corporate_url,
            'business_types'          => Arr::flatten($lead->business_types->toArray()),
            // 'sic_codes'               => Arr::flatten($lead->psc_codes->toArray()),
            'naics_codes'             => Arr::flatten($lead->naics_codes->toArray()),
            'psc_codes'               => Arr::flatten($lead->psc_codes->toArray()),
            'contacts'                => $lead->contacts->toArray(),
            'physical_country'        => $lead->countries->toArray(),
            'physical_state'          => $lead->states->toArray(),
            'physical_city'           => $lead->cities->toArray(),
            'physical_zip'            => $lead->zips->toArray(),
            'physical_streets'        => $lead->physicalStreets->toArray(),
            'mail_country'            => $lead->mail_countries->toArray(),
            'mail_state'              => $lead->mail_states->toArray(),
            'mail_city'               => $lead->mail_cities->toArray(),
            'mail_zip'                => $lead->mailZips->toArray(),
            'country_of_incorporation'=> $lead->countryOfIncorpo->toArray(),
            'state_of_incorporation'  => $lead->stateOfIncorpo->toArray(),
            // 'mailing_streets'        => $lead->mailingStreets->toArray(),
          );

        }

        $data['paginate'] = array(
          'total' => $leads->total(),
          'currentPage' => $leads->currentPage()

        );
        return dd($data);
       return Lead::simplifyArray($leads);

        //return dd(Lead::simplifyArray($leads));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->has('sic_codes')) {

            $sic_codes = $request->sic_codes;

            foreach ($sic_codes as $sic_code) {

                $sic = SicCode::firstOrCreate(['sic_code' => $sic_code] );

                $sic_id[] = $sic->id;
            }
        }

        // Psc code

        if ($request->has('psc_codes')) {

           $psc_codes = $request->psc_codes;

           foreach ($psc_codes as $psc_code) {

               $psc = PscCode::firstOrCreate(['psc_code' => $psc_code] );

               $psc_id[] = $psc->id;
           }
        }

        // NAICS codes

        if ($request->has('naics_codes')) {

            $naics_codes = $request->naics_codes;

            foreach ($naics_codes as $naics_code) {

                $naics = NaicsCode::firstOrNew(['naics_code' => $naics_code]);

                if (isset($naics->id)) {

                    $naics_id[] = $naics->id;

                 }else{

                    $naics_id[] = NaicsCode::firstOrNew(['naics_title' => "false"])->id;
                }
            }

        }

        // Leads

        if ($request->has('legal_business_name')) {

            $legal = $request->legal_business_name;

        }else{

            $legal = "";
        }

        if ($request->has('dba_name')) {

            $dba_name = $request->dba_name;

        }else{

            $dba_name = "";
        }

        if ($request->has('corporate_url')) {

            $url = $request->corporate_url;

        }else{

            $url = "";
        }

        if ($request->has('business_start_date')) {

            $start_date = $request->business_start_date;

            $a = substr_replace( $start_date, '/', -4, 0 );
            $b = substr_replace( $a, '/', -7, 0 );
            $busDate = date('Y-m-d', strtotime(str_replace('-', '/', $b)));

        }else{

            $busDate = "";
        }

        if ($request->has('employee_count')) {

            $employee_count = $request->employee_count;

        }else{

            $employee_count = "";
        }

        $lead = Lead::firstOrNew(['legal_business_name'=> $legal, 'dba_name' => $dba_name, 'corporate_url' => $url, 'business_start_date' => $busDate, 'employee_count' => $employee_count ]);

        if (isset($lead->id)) {

            $lead_id = $lead->id;

        }else{

            $create_lead  = Lead::create(['legal_business_name'=> $legal, 'dba_name' => $dba_name, 'corporate_url' => $url, 'business_start_date' => $busDate, 'employee_count' => $employee_count, 'psc_code_id' => $psc_id, 'sic_code_id' => $sic_id, 'naics_code_id' => $naics_id]);

            $lead_id = $create_lead->id;
        }

        // physical country

        if ($request->has('country_code')) {

            $country_code = $request->country_code;

            if ($country_code == '') {

               $country_code = 'false';
            }

            $country = Country::firstOrCreate(['country' => $country_code]);

            $phy_country_id = $country->id;
        }

        // country of incorporation

        if ($request->has('country_of_incorporation')) {

            $country_inco = $request->country_of_incorporation;

            if ($country_inco == '') {

               $country_inco = 'false';
            }

            $country_incorpo = Country::firstOrCreate(['country' => $country_inco]);

            $country_inco_id = $country_incorpo->id;
        }

        // physical state

        if ($request->has('physical_state')) {

            $physical_state = $request->physical_state;

            if ($physical_state == '') {

               $physical_state = 'false';
            }

            $phy_state = State::firstOrCreate(['country_id' => $phy_country_id,
                'state' => $physical_state]);

            $phy_state_id = $phy_state->id;
        }

        // state of incorporation

        if ($request->has('state_of_incorporation')) {

            $state_inco = $request->state_of_incorporation;

            if ($state_inco == '') {

               $state_inco = 'false';
            }

            $state_incorpo = State::firstOrCreate(['country_id' => $country_inco_id,
                'state' => $state_inco]);

            $state_inco_id = $state_incorpo->id;
        }

        // City

        if ($request->has('physical_city')) {

            $physical_city = $request->physical_city;

            if ($physical_city == '') {

               $physical_city = 'false';
            }

            $phy_city = City::firstOrCreate(['state_id' => $phy_state_id,
                'city' => $physical_city]);

            $phy_city_id = $phy_city->id;
        }

        // Zip

        if ($request->has('zip_code')) {

            $phy_zip_code = $request->zip_code;

            if ($phy_zip_code == '') {

               $phy_zip_code = 'false';
            }

            $phy_zip = Zip::firstOrCreate(['city_id' => $phy_city_id,
                'zip' => $phy_zip_code]);

            $phy_zip_id = $phy_zip->id;

        }

        // Zip4

        if ($request->has('zip4_code')) {

            $phy_zip4_code = $request->zip4_code;

            if ($phy_zip4_code == '') {

               $phy_zip4_code = 'false';
            }

            $phy_zip4 = Zip4::firstOrCreate(['city_id' => $phy_city_id,
                'zip_4' => $phy_zip4_code]);

            $phy_zip4_id = $phy_zip4->id;
        }

        // physical addresses

       $phy_address = PhysicalAddress::firstOrCreate(['lead_id'=> $lead_id, 'phy_country_id' => $phy_country_id, 'phy_state_id' => $phy_state_id, 'phy_city_id' => $phy_city_id, 'phy_zip_id' => $phy_zip_id, 'phy_zip4_id' => $phy_zip4_id, 'state_of_incorporation' => $state_inco_id, 'country_of_incorporation' => $country_inco_id]);

       $phys_address_id = $phy_address->id;

       // Physical Street

       if ($request->has('physical_address')) {

           $physical_address = $request->physical_address;

           $phy_add_one = $physical_address['physical_address_1'];

           $phy_add_two = $physical_address['physical_address_2'];

           if ($phy_add_one == "") {
                $phy_add[] = "false";
           }else{
                $phy_add[] = $phy_add_one;
           }

            if ($phy_add_two == "") {
                $phy_add[] = "false";
           }else{
                $phy_add[] = $phy_add_two;
           }

           foreach ($phy_add as $physical) {

                $street = PhysicalStreet::firstOrCreate(['physical_address_id' => $phys_address_id, 'physical_address' => $physical]);
            }
       }


        // Mail Country

       if ($request->has('mailing_country')) {

            $mailing_country = $request->mailing_country;

            if ($mailing_country == '') {

               $mailing_country = 'false';
            }

            $mail_country = Country::firstOrCreate(['country' => $mailing_country ]);

            $mail_country_id = $mail_country->id;
       }

        // Mail State

       if ($request->has('mailing_state')) {

            $mailing_state = $request->mailing_state;

            if ($mailing_state == '') {

               $mailing_state = 'false';
            }

            $mail_state = State::firstOrCreate(['country_id' => $mail_country_id, 'state' => $mailing_state ]);

            $mail_state_id = $mail_state->id;

       }

       // Mailing City

        if ($request->has('mailing_city')) {

            $mailing_city = $request->mailing_city;

            if ($mailing_city == '') {

               $mailing_city = 'false';
            }

            $mail_city = City::firstOrCreate(['state_id' => $mail_state_id,
                'city' => $mailing_city]);

            $mail_city_id = $mail_city->id;
        }

        // Zip

        if ($request->has('mailing_zip')) {

            $mailing_zip = $request->mailing_zip;

            if ($mailing_zip == '') {

               $mailing_zip = 'false';
            }

            $mail_zip = Zip::firstOrCreate(['city_id' => $mail_city_id,
                'zip' => $mailing_zip]);

            $mail_zip_id = $mail_zip->id;

        }

        // Zip4

        if ($request->has('mailing_zip4')) {

            $mailing_zip4 = $request->mailing_zip4;

            if ($mailing_zip4 == '') {

               $mailing_zip4 = 'false';
            }

            $mail_zip4 = Zip4::firstOrCreate(['city_id' => $mail_city_id,
                'zip_4' => $mailing_zip4]);

            $mail_zip4_id = $mail_zip4->id;
        }

        // mailing addresses

       $mail_address = MailingAddress::firstOrCreate(['lead_id'=> $lead_id, 'mail_country_id' => $mail_country_id, 'mail_state_id' => $mail_state_id, 'mail_city_id' => $mail_city_id, 'mail_zip_id' => $mail_zip_id, 'mail_zip4_id' => $mail_zip4_id ]);

       $mailing_address_id = $mail_address->id;


       // Mailing Street

       if ($request->has('mailing_address')) {

           $mailing_address = $request->mailing_address;

           $mail_add_one = $mailing_address['mailing_address_1'];

           $mail_add_two = $mailing_address['mailing_address_2'];

           if ($mail_add_one == "") {
                $mail_add[] = "false";
           }else{
                $mail_add[] = $mail_add_one;
           }

            if ($mail_add_two == "") {
                $mail_add[] = "false";
           }else{
                $mail_add[] = $mail_add_two;
           }

           foreach ($mail_add as $mailing_add) {

                $street = MailingStreet::firstOrCreate(['mailing_address_id' => $mailing_address_id, 'mailing_address' => $mailing_add]);
            }
        }

       // Annual Revenue

       if ($request->has('annual_revenue')) {

            $annual_revenue = $request->annual_revenue;

            if ($annual_revenue == '') {

                $annual_revenue = '$0';
            }

            $revenue = AnnualRevenue::firstOrCreate(['annual_revenue' => $annual_revenue ]);

            $revenue_id = $revenue->id;
       }

       // Fiscal Year

       if ($request->has('fiscal_year')) {

            $fiscal_year = $request->fiscal_year;

            if ($fiscal_year == '') {

                $fiscal_year = 0;
            }

            $fiscal = FiscalYear::firstOrCreate(['fiscal_year' => $fiscal_year ]);

            $fiscal_id = $fiscal->id;
       }

       // Company Division

       if ($request->has('company_division')) {

            $company_division = $request->company_division;

            if ($company_division == '') {

                $company_division = "false";
            }

            $division_number = $request->division_number;

            if ($division_number == '') {

                $division_number = "false";
            }

            $divison = CompanyDivision::firstOrCreate(['division_number' => $division_number, 'company_division' => $company_division ]);

            $divison_id = $divison->id;
       }

       // Lead Metas

       $lead_meta = LeadMeta::firstOrCreate(['lead_id'=> $lead_id,'fiscal_year_id'=> $fiscal_id, 'company_division_id'=> $divison_id, 'annual_revenue_id'=> $revenue_id]);


       if ($request->contact_details) {

           $contacts = $request->contact_details;
           $i = 0;
           foreach ($contacts as $key => $contact) {
               $i++;
                $contactName = $contact['contact_name'];

               if ($contactName == "") {

                   $contact_det = array("first" => "", "last" => "");
               }else{

                    $contact_det = $this->splitString($contactName);
               }

               if ($contact_det['first'] == '' && $contact_det['last'] == '') {

               }else{
                   $cont = Contact::firstOrCreate(['first_name'=> $contact_det['first'], 'last_name' => $contact_det['last'],  'lead_id' => $lead_id, 'contact_order' => $i]);


                   if (isset($cont->id)) {

                       $cont_id = $cont->id;

                       $email = $contact['email_address'];

                       if ($email == '') {

                           $email = "";
                       }

                       $fax = $contact['business_fax'];

                       if ($fax == '') {

                           $fax = "";
                       }

                       $phone = $contact['contact_phone'];

                       if ($phone == '') {

                           $phone = "";
                       }

                       $phone_ext = $contact['contact_phone_ext'];

                       if ($phone_ext == '') {

                           $phone_ext = "";
                       }

                       $cont_details = ContactDetail::firstOrCreate(['lead_id'=> $lead_id, 'contact_id' => $cont_id,  'email_address' => $email, 'business_fax' => $fax, 'contact_phone' => $phone, 'contact_phone_ext' => $phone_ext ]);
                   };
               }
           }

           if ($cont_details) {

               return "Data Inserted Successfully....!";
           }
       }

    }

    // Contact Information


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $lead = Lead::find($id);

        $data = array(
          // 'legal_business_name' => $lead->legal_business_name,
          // 'dba_name' => $lead->dba_name,
          // 'corporate_url' => $lead->corporate_url,
          // 'business_start_date' => $lead->business_start_date  ,
          // 'employee_count' => $lead->employee_count,
          // 'naics_codes' => $lead->naicsCodes->toArray(),
          // 'sic_codes' => $lead->sicCodes->toArray(),
          // 'psc_codes' => $lead->pscCodes->toArray(),
        );

        //return $data;
        dd($data);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function splitString($contact){

        $csvContact = explode(" ", $contact);

        for ($i=0; $i < count($csvContact) ; $i++) {
            if ($i == 0) {
                $name['first'] = $csvContact[$i];
            }else{
                $lastContactName[] = $csvContact[$i];
            }
        }
        if(isset($lastContactName)){

            $name['last'] = implode(" ", $lastContactName);
        }else{

            $name['last'] = "";
        }


        return $name;
    }

}

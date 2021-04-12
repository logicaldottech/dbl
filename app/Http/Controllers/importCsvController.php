<?php

namespace App\Http\Controllers;
use App\Contact;
use App\ContactDetail;
use App\Lead;
use App\SicCode;
use App\PscCode;
use App\NaicsCode;
use App\Country;
use App\State;
use App\City;
use App\Zip;
use App\Zip4;
use App\PhysicalAddress;
use App\PhysicalStreet;
use App\MailingAddress;
use App\MailingStreet;
use App\NaicsLead;
use App\FiscalYear;
use App\CompanyDivision;
use App\AnnualRevenue;
use App\LeadMeta;

use Illuminate\Http\Request;

class importCsvController extends Controller
{
    public function index(){

die;
	    $file = base_path('resources/csv/leads.csv');

	    $leadsArr = $this->csvToArray($file);
	    // print_r($customerArr);die;

	    foreach ($leadsArr as $data)
	    {
	    	 //leads
	    	$csvLegal = $data['legal_business_name'];
	    	$csvDba = $data['dba_name'];
	    	$csvUrl = $data['corporate_url'];
	    	$csvBsd = $data['business_start_date'];
	    	$csvEmply = $data['employee_count'];

			 // SIC codes
		    $sic = $data['SIC CODE STRING'];

	    	if ($sic == '') {
	    		$sic_code = 'false';
	    	}else{
		    	$sicArr = explode('.', $sic);
		    }

		if (isset($sicArr)) {
		    // insert data into sic_codes table
		    $sic = new SicCode;
		    foreach ($sicArr as $key => $sicA) {

		        $sicCode = SicCode::where('sic_code', '=', $sicA)->get('id');

		        if ($sicCode->isEmpty()) {
		        	echo "stop sic";
		        	echo $key;  die;
		          $sic = SicCode::create(['sic_code'=> $sicA]);
				}else{

					$sicId[] = $sicCode[0]->id;
				}
	        }
	        $sId = $sicId;
	   	}else{

	        $sId = 'false';

	   	}



	   	// PSC codes
	    	$psc = $data['PSC CODE STRING'];


	    	if ($psc == '') {
	    		$psc_code = 'false';
	    	}else{
		    	$pscArr = explode('.', $psc);
		    }

		 if (isset($pscArr)) {
		    // insert data into sic_codes table
		    $psc = new PscCode;
		    foreach ($pscArr as $key => $pscA) {
		    	// insert data into psc_codes table
		        $pscCode = PscCode::where('psc_code', '=', $pscA)->get('id');

		        if ($pscCode->isEmpty()) {
		        	echo "stop psc";
		        	echo $key;die;
		          $psc = PscCode::create(['psc_code'=> $pscA]);
		        }else{

		        	$pscId[] = $pscCode[0]->id;
		        }
	        }

	        $pId = $pscId;
	    }else{

	    	$pId = 'false';
	    }



	    $naics = $data['NAICS CODE STRING'];

	    	if ($naics == '') {
	    		$naics = 'false';
	    	}else{
		    	$naicsArr = explode('.', $naics);
		    	$newNaics =preg_replace("/[^0-9,.]/", "", $naicsArr);
		    }


		if (isset($newNaics)) {

		    $naicsCode = new NaicsCode;

	    	foreach ($newNaics as $keyOne => $valueOne) {

	    		$naData = NaicsCode::where('naics_code', '=', $valueOne)->get('id');

	    		if ($naData->isEmpty()) {
	    			$cd =  NaicsCode::where('naics_title', '=', 'false')->get('id');

	    			$naicsId[] = $cd[0]->id;
	    		}else{

	    			$naicsId[] = $naData[0]->id;

	    		}
	    	}
	    	$nId = $naicsId;
	    }else{

	    	$nId = 'false';
	    }

      // Business types
	    $busType = $data['BUS TYPE STRING'];

    	if ($busType == '') {
    		$bus_type = 'false';
    	}else{
	    	$busArr = explode('.', $busType);
	    }

    // insert data into business_types table
	    if (isset($busArr)) {

	    	 $bus = new BusinessType;
	    	foreach ($busArr as $key => $valueTwo) {

		        $busCode = BusinessType::where('business_type', '=', $valueTwo)->get('id');

		        if ($busCode->isEmpty()) {

		          $bus = BusinessType::create(['business_type'=> $valueTwo]);

		        	$busId[] = $bus->id;

		        }else{

		        	$busId[] = $busCode[0]->id;
		        }
		    }
	    }else{

	    	$busId = 'false';
	    }

	    	// insert data into Leads table
	    	$lead = new Lead;

        	$a = substr_replace( $csvBsd, '/', -4, 0 );
        	$b = substr_replace( $a, '/', -7, 0 );
    	$busDate = date('Y-m-d', strtotime(str_replace('-', '/', $b)));

           $lead = Lead::create(['legal_business_name'=> $csvLegal, 'dba_name' => $csvDba, 'corporate_url' => $csvUrl, 'business_start_date' => $busDate, 'employee_count' => $csvEmply, 'psc_code_id' => $pId, 'sic_code_id' => $sId, 'naics_code_id' => $nId, 'business_type_id' => $busId ]);

           unset($sicId);
           unset($pscId);
           unset($naicsId);
           unset($busId);
		}

	    echo "Data Insert Successfully....!";
	}



	function csvToArray($filename = '', $delimiter = ',')
	{
	    if (!file_exists($filename) || !is_readable($filename))
	        return false;

	    $header = null;
	    $data = array();
	    if (($handle = fopen($filename, 'r')) !== false)
	    {
	        while (($row = fgetcsv($handle, 100000, $delimiter)) !== false)
	        {
	            if (!$header)
	                $header = $row;
	            else
	                $data[] = array_combine($header, $row);

	        }
	        fclose($handle);
	    }

	    return $data;
	}


	public function addNaicsLeads(){
die;
   		$file = base_path('resources/csv/naics_leads.csv');

	    $naicsLeads = $this->csvToArray($file);

	    foreach ($naicsLeads as $data)
	    {
	    	$naics = $data['NAICS CODE STRING'];

	    	if ($naics == '') {
	    		$naics = 'false';
	    	}else{
		    	$naicsArr = explode('.', $naics);
		    	$newNaics =preg_replace("/[^0-9,.]/", "", $naicsArr);
		    }


		if (isset($newNaics)) {

		    $naicsCode = new NaicsCode;

	    	foreach ($newNaics as $keyOne => $valueOne) {

	    		$naData = NaicsCode::where('naics_code', '=', $valueOne)->get('id');

	    		if ($naData->isEmpty()) {
	    			echo "stop naics";
	    			echo $keyOne;die;
	    		}else{

	    			$naicsId[] = $naData[0]->id;

	    		}
	    	}

	    	$nId = json_encode($naicsId);
	    }else{

	    	$nId = 'false';
	    }

	    }
	    echo "Data Inserted Successfully....!";
   	}


   	public function addSicLeads(){
die;

   		$file = base_path('resources/csv/sic_codes.csv');

	    $sicCodes = $this->csvToArray($file);

	    foreach ($sicCodes as $data)
	    {

	    	 // SIC codes
		    $sic = $data['SIC CODE STRING'];

	    	if ($sic == '') {
	    		$sic_code = 'false';
	    	}else{
		    	$sicArr = explode('.', $sic);
		    }

		    if (isset($sicArr)) {
		    // insert data into sic_codes table
		    foreach ($sicArr as $sicA) {

		    	 $sic = new SicCode;

		        $sicCode = SicCode::where('sic_code', '=', $sicA)->get('id');

		        if ($sicCode->isEmpty()) {

		          $sic = SicCode::create(['sic_code'=> $sicA]);
				}
	        }
	    }
	   }
	    echo "Data Inserted Successfully....!";
	}

		public function addPscLeads(){
die;
   		$file = base_path('resources/csv/psc_codes.csv');

	    $pscCodes = $this->csvToArray($file);

	    foreach ($pscCodes as $data)
	    {

	    	// PSC codes
	    	$psc = $data['PSC CODE STRING'];


	    	if ($psc == '') {
	    		$psc_code = 'false';
	    	}else{
		    	$pscArr = explode('.', $psc);
		    }

		 if (isset($pscArr)) {
		    // insert data into sic_codes table
		    foreach ($pscArr as $pscA) {
		    	// insert data into psc_codes table
		    	 $psc = new PscCode;

		        $pscCode = PscCode::where('psc_code', '=', $pscA)->get('id');

		        if ($pscCode->isEmpty()) {

		          $psc = PscCode::create(['psc_code'=> $pscA]);
		        }
	        }
	    }
	    }
	echo "Data Inserted Successfully....!";
	}


	public function addContactDetails(){
die;
		$file = base_path('resources/csv/contacts.csv');

	    $contactArr = $this->csvToArray($file);

	    // print_r($customerArr);die;

	    foreach ($contactArr as $key => $data)
	    {
		// contact
	    	 $count = 1;
	    	 $contact = $data['CORPORATE CONTACT'];
	    	 $id = $data['ID'];

	    	 if($contact == ''){
	    	 	$newContactOne = '';
	    	 }else{
	    	 	$newContactOne = $this->splitString($contact);
	    	 	$newContactOne['order'] = 1;
	    	 	$newContactOne['phone'] = $data['1ST CONTACT PHONE'];
	    	 	$newContactOne['phone_ext'] = $data['1ST CONTACT PHONE EXT'];
	    	 	$newContactOne['fax'] = $data['1ST BUSINESS FAX'];
	    	 	$newContactOne['email'] = $data['1ST EMAIL ADDRESS'];

	    	 	if (!array_key_exists("last",$newContactOne))
				  {
				 $newContactOne['last'] = 'false';
				  }

	    	 	$contArr[] = $newContactOne;
	    	 	$count++;
	    	 }

	    	 $contactTwo = $data['2ND BUSINESS CONTACT'];
	    	 if($contactTwo == ''){

	    	 	$newcontactTwo = '';

	    	 }else{

	    	 	$newcontactTwo = $this->splitString($contactTwo);
	    	 	$newcontactTwo['order'] = $count;
	    	 	$newcontactTwo['phone'] = $data['2ND CONTACT PHONE'];
	    	 	$newcontactTwo['phone_ext'] = $data['2ND CONTACT PHONE EXT'];
	    	 	$newcontactTwo['fax'] = $data['2ND BUSINESS FAX'];
	    	 	$newcontactTwo['email'] = $data['2ND EMAIL ADDRESS'];

	    	 	if (!array_key_exists("last",$newcontactTwo))
				  {
				 $newcontactTwo['last'] = 'false';
				  }

	    	 	$contArr[] = $newcontactTwo;

	    	 	$count++;

	    	 }

	    	 $contactThree = $data['3RD BUSINESS CONTACT'];
	    	 if($contactThree == ''){
	    	 	$newcontactThree = '';
	    	 }else{
	    	 	$newcontactThree = $this->splitString($contactThree);
	    	 	$newcontactThree['order'] = $count;
	    	 	$newcontactThree['phone'] = $data['3RD CONTACT PHONE'];
	    	 	$newcontactThree['phone_ext'] = $data['3RD CONTACT PHONE EXT'];
	    	 	$newcontactThree['fax'] = $data['3RD BUSINESS FAX'];
	    	 	$newcontactThree['email'] = $data['3RD EMAIL ADDRESS'];

	    	 	if (!array_key_exists("last",$newcontactThree))
				  {
				 $newcontactThree['last'] = 'false';
				  }

	    	 	$contArr[] = $newcontactThree;
	    	 	$count++;

	    	 }

	    	 $contactFour = $data['4TH BUSINESS CONTACT'];
	    	 if($contactFour == ''){
	    	 	$newContactFour = '';
	    	 }else{
	    	 	$newContactFour = $this->splitString($contactFour);
	    	 	$newContactFour['order'] = $count;
	    	 	$newContactFour['phone'] = $data['4TH CONTACT PHONE'];
	    	 	$newContactFour['phone_ext'] = $data['4TH CONTACT PHONE EXT'];
	    	 	$newContactFour['fax'] = $data['4TH BUSINESS FAX'];
	    	 	$newContactFour['email'] = $data['4TH EMAIL ADDRESS'];

	    	 	if (!array_key_exists("last",$newContactFour))
				  {
				 $newContactFour['last'] = 'false';
				  }

	    	 	$contArr[] = $newContactFour;
	    	 	$count++;
	    	 }

	    	 $contactFive = $data['5TH BUSINESS CONTACT'];
	    	 if($contactFive == ''){
	    	 	$newContactFive = '';
	    	 }else{
	    	 	$newContactFive = $this->splitString($contactFive);
	    	 	$newContactFive['order'] = $count;
	    	 	$newContactFive['phone'] = $data['5TH CONTACT PHONE'];
	    	 	$newContactFive['phone_ext'] = $data['5TH CONTACT PHONE EXT'];
	    	 	$newContactFive['fax'] = $data['5TH BUSINESS FAX'];
	    	 	$newContactFive['email'] = $data['5TH EMAIL ADDRESS'];

	    	 	if (!array_key_exists("last",$newContactFive))
				  {
				 $newContactFive['last'] = 'false';
				  }

	    	 	$contArr[] = $newContactFive;
	    	 	$count++;
	    	 }

	    	 $contactSix = $data['6TH BUSINESS CONTACT'];
	    	 if($contactSix == ''){
	    	 	$newContactSix = '';
	    	 }else{
	    	 	$newContactSix = $this->splitString($contactSix);
	    	 	$newContactSix['order'] = $count;
	    	 	$newContactSix['phone'] = $data['6TH CONTACT PHONE'];
	    	 	$newContactSix['phone_ext'] = $data['6TH CONTACT PHONE EXT'];
	    	 	$newContactSix['fax'] = $data['6TH BUSINESS FAX'];
	    	 	$newContactSix['email'] = $data['6TH EMAIL ADDRESS'];

	    	 	if (!array_key_exists("last",$newContactSix))
				  {
				 $newContactSix['last'] = 'false';
				  }

	    	 	$contArr[] = $newContactSix;
	    	 	$count++;
	    	 }

	    	 $contactSev = $data['7TH BUSINESS CONTACT'];
	    	 if($contactSev == ''){
	    	 	$newcontactSev = '';
	    	 }else{
	    	 	$newcontactSev = $this->splitString($contactSev);
	    	 	$newcontactSev['order'] = $count;
	    	 	$newcontactSev['phone'] = $data['7TH CONTACT PHONE'];
	    	 	$newcontactSev['phone_ext'] = $data['7TH CONTACT PHONE EXT'];
	    	 	$newcontactSev['fax'] = $data['7TH BUSINESS FAX'];
	    	 	$newcontactSev['email'] = $data['7TH EMAIL ADDRESS'];

	    	 	if (!array_key_exists("last",$newcontactSev))
				  {
				 $newcontactSev['last'] = 'false';
				  }

	    	 	$contArr[] = $newcontactSev;
	    	 	$count++;
	    	 }

	    	 $contactEt = $data['8TH BUSINESS CONTACT'];
	    	 if($contactEt == ''){
	    	 	$newContactEt = '';
	    	 }else{
	    	 	$newContactEt = $this->splitString($contactEt);
	    	 	$newContactEt['order'] = $count;
	    	 	$newContactEt['phone'] = $data['8TH CONTACT PHONE'];
	    	 	$newContactEt['phone_ext'] = $data['8TH CONTACT PHONE EXT'];
	    	 	$newContactEt['fax'] = $data['8TH BUSINESS FAX'];
	    	 	$newContactEt['email'] = $data['8TH EMAIL ADDRESS'];

	    	 	if (!array_key_exists("last",$newContactEt))
				  {
				 $newContactEt['last'] = 'false';
				  }

	    	 	$contArr[] = $newContactEt;
	    	 	$count++;
	    	 }

	    	 $contactNt = $data['9TH BUSINESS CONTACT'];
	    	 if($contactNt == ''){
	    	 	$newcontactNt = '';
	    	 }else{
	    	 	$newcontactNt = $this->splitString($contactNt);
	    	 	$newcontactNt['order'] = $count;
	    	 	$newcontactNt['phone'] = $data['9TH CONTACT PHONE'];
	    	 	$newcontactNt['phone_ext'] = $data['9TH CONTACT PHONE EXT'];
	    	 	$newcontactNt['fax'] = $data['9TH BUSINESS FAX'];
	    	 	$newcontactNt['email'] = $data['9TH EMAIL ADDRESS'];

	    	 	if (!array_key_exists("last",$newcontactNt))
				  {
				 $newcontactNt['last'] = 'false';
				  }

	    	 	$contArr[] = $newcontactNt;
	    	 	$count++;
	    	 }

	    	 $contactTen = $data['10TH BUSINESS CONTACT'];
	    	 if($contactTen == ''){
	    	 	$newcontactTen = '';
	    	 }else{
	    	 	$newcontactTen = $this->splitString($contactTen);
	    	 	$newcontactTen['order'] = $count;
	    	 	$newcontactTen['phone'] = $data['10TH CONTACT PHONE'];
	    	 	$newcontactTen['phone_ext'] = $data['10TH CONTACT PHONE EXT'];
	    	 	$newcontactTen['fax'] = $data['10TH BUSINESS FAX'];
	    	 	$newcontactTen['email'] = $data['10TH EMAIL ADDRESS'];

	    	 	if (!array_key_exists("last",$newcontactTen))
				  {
				 $newcontactTen['last'] = 'false';
				  }

	    	 	$contArr[] = $newcontactTen;
	    	 	$count++;
	    	 }

	    	// Insert data into contacts table
	    	$cont = new Contact;

	    	foreach ($contArr as $key => $value) {

	    		$contData = Contact::where('first_name', '=', $value['first'])
		        		 	->where('last_name', '=', $value['last'])
		        		 	->where('lead_id', '=', $id)->get('id');

		       if ($contData->isEmpty()) {

	        	$tabCont = Contact::create(['first_name'=> $value['first'], 'last_name' => $value['last'],  'lead_id' => $id, 'contact_order' => $value['order']]);

	        	$contId = $tabCont->id;

		        }else{

		        		$contId = $contData[0]->id;
		        	}

		        $contDeatil = new ContactDetail;

		        $contdData = ContactDetail::where('lead_id', '=', $id)
		        		 	->where('contact_id', '=', $contId)
		        		 	->where('email_address', '=', $value['email'])->get('id');

		       	if ($contdData->isEmpty()) {

	        	$tabdCont = ContactDetail::create(['lead_id'=> $id, 'contact_id' => $contId,  'email_address' => $value['email'], 'business_fax' => $value['fax'], 'contact_phone' => $value['phone'], 'contact_phone_ext' => $value['phone_ext']]);

		        }
	    	}
	    	 unset($contArr);
	  }
	  echo "Data Inserted Successfully.....!";
	}



	// code for physical addresses csv

	public function addphyAddress(){
die;
		$file = base_path('resources/csv/physical_addresses.csv');

	    $phyAddress = $this->csvToArray($file);

	    // print_r($phyAddress);die;

	    foreach ($phyAddress as $data)
	    {
	    	$id = $data['ID'];
	    	// country
	    	$csvContry = $data['COUNTRY CODE'];

	    	 if ($csvContry == '') {
	    	 	$csvContry = 'false';
	    	 }

	    	 //state
	    	 $csvState = $data['PHYSICAL STATE'];

	    	 if ($csvState == '') {
	    	 	$csvState = 'false';
	    	 }

	    	 // city
	    	 $csvCity = $data['PHYSICAL CITY'];

	    	 if ($csvCity == '') {
	    	 	$csvCity = 'false';
	    	 }

	    	 //Zip
	    	$csvZip = $data['ZIP CODE / POSTAL CODE'];

	    	if ($csvZip == '') {
	    	 	$csvZip = 'false';
	    	 }

	    	 // zip4
	    	$csvZip4 = $data['USA ZIP CODE +4'];

	    	if ($csvZip4 == '') {
	    	 	$csvZip4 = 'false';
	    	 }

	    	 //physical address
	    	$phyStreetOne = $data['PHYSICAL ADDRESS'];

	    	if ($phyStreetOne == "") {
	    		$phyStreetOne = 'false';
	    	}

	    	$phyStreetTwo = $data['PHYSICAL ADDRESS 2'];

	    	if ($phyStreetTwo == "") {
	    		$phyStreetTwo = 'false';
	    	}

	    	//state and country of incorporation
	    	$soi = $data['STATE OF INCORPORATION'];

	    	if ($soi == "") {
	    		$soi = 'false';
	    	}

	    	$coi = $data['COUNTRY OF INCORPORATION'];

	    	if ($coi == "") {
	    		$coi = 'false';
	    	}

	    	//physical address
	    	$phyStreetOne = $data['PHYSICAL ADDRESS'];

	    	if ($phyStreetOne == "") {
	    		$phyStreetOne = 'false';
	    	}

	    	$phyStreetTwo = $data['PHYSICAL ADDRESS 2'];

	    	if ($phyStreetTwo == "") {
	    		$phyStreetTwo = 'false';
	    	}

	    	// insert data into countries table using mailing address country
	        $country = new Country;


        	$cdata = Country::where('country', '=', $csvContry)->get('id');

        	if ($cdata->isEmpty()) {

	        	$country = Country::create(['country'=> $csvContry]);
	        	$countryId = $country->id;

	        }else{
	        		$countryId = $cdata[0]->id;
	        	}

	        // insert data into countries table using country code
        	$countryOf = Country::where('country', '=', $coi)->get('id');

        	if ($countryOf->isEmpty()) {

	        	$countryOfIn = Country::create(['country'=> $coi]);
	        	$coId = $countryOfIn->id;

	        }else{
	        		$coId = $countryOf[0]->id;
	        	}


	    	// insert data into states table using physical state

       		$state = new State;

	        $sdata = State::where('country_id', '=', $countryId)
	        		 	->where('state', '=', $csvState)->get('id');

	        if ($sdata->isEmpty()) {

	        	$state = State::create(['country_id'=> $countryId, 'state' => $csvState]);

	        	$stateId = $state->id;

	        }else{

        		$stateId = $sdata[0]->id;

	        }


	        //  state of Incorporation
		     $stateOf = State::where('country_id', '=', $coId)
		        		 	->where('state', '=', $soi)->get('id');

		        if ($stateOf->isEmpty()) {

		        	$stateofIn = State::create(['country_id'=> $coId, 'state' => $soi]);

		        	$soId = $stateofIn->id;

		        }else{

	        		$soId = $stateOf[0]->id;

		        }


		    // insert data into city table using physical city

	    	$city = new City;

	        $ctdata = City::where('state_id', '=', $stateId)
	        		 	->where('city', '=', $csvCity)->get('id');

	        if ($ctdata->isEmpty()) {

	           $city = City::create(['state_id'=> $stateId, 'city' => $csvCity]);

	        	$cityId = $city->id;

	        }else{

	        	$cityId = $ctdata[0]->id;
	        }


	        // insert data into Zip table using ZIP CODE / POSTAL CODE

	    	 $zip = new Zip;

	        $zdata = Zip::where('city_id', '=', $cityId)
	        		 	->where('zip', '=', $csvZip)->get('id');

	        if ($zdata->isEmpty()) {

	           $zip = Zip::create(['city_id'=> $cityId, 'zip' => $csvZip]);

	        	$zipId = $zip->id;

	        }else{

	        	$zipId = $zdata[0]->id;
	        }


	        // insert data into Zip4 table using USA ZIP CODE +4

	    	 $zip4 = new Zip4;

	        $zzdata = Zip4::where('city_id', '=', $cityId)
	        		 	->where('zip_4', '=', $csvZip4)->get('id');

	        if ($zzdata->isEmpty()) {

	           $zip4 = Zip4::create(['city_id'=> $cityId, 'zip_4' => $csvZip4]);

	        	$zipFourId = $zip4->id;

	        }else{

	        	$zipFourId = $zzdata[0]->id;
	        }


	        // insert data into physical_address table
	        $physical = new PhysicalAddress;

	        $phyAdd = PhysicalAddress::where('lead_id', '=', $id)
	        		 	->where('phy_country_id', '=', $countryId)
	        		 	->where('phy_state_id', '=', $stateId)
	        		 	->where('phy_city_id', '=', $cityId)->get('id');

	        if ($phyAdd->isEmpty()) {

	           $mailAddress = PhysicalAddress::create(['lead_id'=> $id, 'phy_country_id' => $countryId, 'phy_state_id' => $stateId, 'phy_city_id' => $cityId, 'phy_zip_id' => $zipId, 'phy_zip4_id' => $zipFourId, 'state_of_incorporation' => $soId, 'country_of_incorporation' => $coId]);

	        	$phyAddId = $mailAddress->id;

	        }else{

	        	$phyAddId = $phyAdd[0]->id;
	        }


	        // insert data into physical_streets table
		    $phyStreet = new PhysicalStreet;

	        $phyStreetcheck = PhysicalStreet::where('physical_address_id', '=', $phyAddId)
	        		 				->where('physical_address', '=', $phyStreetOne)->get('id');

	        if ($phyStreetcheck->isEmpty()) {

	        	if ($phyStreetOne !== 'false') {

	        		$phyStreet1 = PhysicalStreet::create(['physical_address_id' => $phyAddId, 'physical_address' => $phyStreetOne]);

	        	}

	  			if ($phyStreetTwo !== 'false') {

	        		$phyStreet2 = PhysicalStreet::create(['physical_address_id' => $phyAddId, 'physical_address' => $phyStreetTwo]);

	        	}

	        }


	    }

	    echo "Data Inserted Successfully...!";
	}


	// Mailing address insert

	public function addMailAddresses(){
die;
	    $file = base_path('resources/csv/mailing_addresses.csv');

	    $customerArr = $this->csvToArray($file);

	    // print_r($customerArr);die;

	    foreach ($customerArr as $data)
	    {

	    	// lead id
	    	$id = $data['ID'];

	    	// country
	    	$csvMailContry = $data['MAILING ADDRESS COUNTRY'];

	    	 if ($csvMailContry == '') {
	    	 	$csvMailContry = 'false';
	    	 }

	    	 //state
	    	 $csvMailState = $data['MAILING ADDRESS STATE OR PROVINCE'];

	    	 if ($csvMailState == '') {
	    	 	$csvMailState = 'false';
	    	 }

	    	 // city
	    	 $csvMailCity = $data['MAILING ADDRESS CITY'];

	    	 if ($csvMailCity == '') {
	    	 	$csvMailCity = 'false';
	    	 }

	    	 //Zip
	    	 $csvMailZip = $data['MAILING ADDRESS ZIP/POSTAL CODE'];

	    	if ($csvMailZip == '') {
	    	 	$csvMailZip = 'false';
	    	 }

	    	 $csvMailZip4 = $data['MAILING ADDRESS ZIP +4'];

	    	if ($csvMailZip4 == '') {
	    	 	$csvMailZip4 = 'false';
	    	 }

	    	 //mailing address
	    	$mailStreetOne = $data['MAILING ADDRESS LINE 1'];

	    	if ($mailStreetOne == "") {
	    		$mailStreetOne = 'false';
	    	}

	    	$mailStreetTwo = $data['MAILING ADDRESS LINE 2'];

	    	if ($mailStreetTwo == "") {
	    		$mailStreetTwo = 'false';
	    	}

	    	 // insert data into mail countries table using country code

        	$mailcData = Country::where('country', '=', $csvMailContry)->get('id');

        	if ($mailcData->isEmpty()) {

	        	$mailCountry = Country::create(['country'=> $csvMailContry]);
	        	$mailCountryId = $mailCountry->id;

	        }else{
	        		$mailCountryId = $mailcData[0]->id;
	        	}


	        // insert data into states table using Mailing state

	        $mailsdata = State::where('country_id', '=', $mailCountryId)
	        		 	->where('state', '=', $csvMailState)->get('id');

	        if ($mailsdata->isEmpty()) {

	        	$mailState = State::create(['country_id'=> $mailCountryId, 'state' => $csvMailState]);

	        	$mailStateId = $mailState->id;

	        }else{

        		$mailStateId = $mailsdata[0]->id;

	        }


	        // insert data into city table using mailing city

	        $mailCtdata = City::where('state_id', '=', $mailStateId)
	        		 	->where('city', '=', $csvMailCity)->get('id');

	        if ($mailCtdata->isEmpty()) {

	           $mailCity = City::create(['state_id'=> $mailStateId, 'city' => $csvMailCity]);

	        	$mailCityId = $mailCity->id;

	        }else{

	        	$mailCityId = $mailCtdata[0]->id;
	        }


	         // insert data into Zip table using ZIP CODE / POSTAL CODE

	        $mailzdata = Zip::where('city_id', '=', $mailCityId)
	        		 	->where('zip', '=', $csvMailZip)->get('id');

	        if ($mailzdata->isEmpty()) {

	           $mailZip = Zip::create(['city_id'=> $mailCityId, 'zip' => $csvMailZip]);

	        	$mailZipId = $mailZip->id;

	        }else{

	        	$mailZipId = $mailzdata[0]->id;
	        }


	         // insert data into Zip4 table using USA ZIP CODE +4

	        $zzMaildata = Zip4::where('city_id', '=', $mailCityId)
	        		 	->where('zip_4', '=', $csvMailZip4)->get('id');

	        if ($zzMaildata->isEmpty()) {

	           $mailZip4 = Zip4::create(['city_id'=> $mailCityId, 'zip_4' => $csvMailZip4]);

	        	$mailZipFourId = $mailZip4->id;

	        }else{

	        	$mailZipFourId = $zzMaildata[0]->id;
	        }


	         // insert data into mailing_address table
	        $mailing = new MailingAddress;

	        $mailAdd = MailingAddress::where('lead_id', '=', $id)
	        		 	->where('mail_city_id', '=', $mailCityId)
	        		 	->where('mail_state_id', '=', $mailStateId)
	        		 	->where('mail_country_id', '=', $mailCountryId)->get('id');

	        if ($mailAdd->isEmpty()) {

	           $mailAddress = MailingAddress::create(['lead_id'=> $id, 'mail_city_id' => $mailCityId, 'mail_state_id' => $mailStateId, 'mail_country_id' => $mailCountryId, 'mail_zip_id' => $mailZipId, 'mail_zip4_id' => $mailZipFourId]);

	        	$mailAddId = $mailAddress->id;

	        }else{

	        	$mailAddId = $mailAdd[0]->id;
	        }


	         // insert data into mailing_streets table
		    $mailStreet = new MailingStreet;

	        $mailStreetcheck = MailingStreet::where('mailing_address_id', '=', $mailAddId)
	        		 				->where('mailing_address', '=', $mailStreetOne)->get('id');

	        if ($mailStreetcheck->isEmpty()) {

	        	if ($mailStreetOne !== 'false') {

	        		$mailStreet1 = MailingStreet::create(['mailing_address_id' => $mailAddId, 'mailing_address' => $mailStreetOne]);

	        	}

	  			if ($mailStreetTwo !== 'false') {

	        		$mailStreet2 = MailingStreet::create(['mailing_address_id' => $mailAddId, 'mailing_address' => $mailStreetTwo]);

	        	}

	        }

	    }

	    echo "Data Inserted Successfully...!";
	}

// lead meta insert
	public function addLeadMetas(){
die;
		$file = base_path('resources/csv/lead_meta.csv');

	    $leadMetas = $this->csvToArray($file);

	    // print_r($leadMetas);die;

	    foreach ($leadMetas as $data)
	    {
	    	// fiscal year
	    	$csvFiscal = $data['FISCAL YEAR END CLOSE DATE'];

	    	if ($csvFiscal == "") {
	    		$csvFiscal = 0;
	    	}

	    	// annual revenue
	    	$csvRevenue = $data['ANNUAL REVENUE (ESTIMATED)'];
	    	if ($csvRevenue == "") {
	    		$csvRevenue = 0;
	    	}

	    	$csvRevenue = str_replace(",", "", $csvRevenue);

	    	$csvRevenue = (int)str_replace("$", "", $csvRevenue);

	    	// company division
	    	$csvcomDiv = $data['COMPANY DIVISION'];

	    	if ($csvcomDiv == "") {
	    		$csvcomDiv = 'false';
	    	}

	    	$csvDivNum = $data['DIVISION NUMBER'];

	    	if ($csvDivNum == "") {
	    		$csvDivNum = 'false';
	    	}

	    	// lead id
	    	$id = $data['ID'];

	    	 // insert data into fiscal_years table
		    $fiscalyear = new FiscalYear;

	        $fydata = FiscalYear::where('fiscal_year', '=', $csvFiscal)->get('id');

	        if ($fydata->isEmpty()) {

	           $fiscalyear = FiscalYear::create(['fiscal_year' => $csvFiscal]);

	        	$fiscalyearId = $fiscalyear->id;

	        }else{

	        	$fiscalyearId = $fydata[0]->id;
	        }

	        // insert data into Annual_revenues table
		    $annualRev = new AnnualRevenue;

	        $revenue = AnnualRevenue::where('annual_revenue', '=', $csvRevenue)->get('id');

	        if ($revenue->isEmpty()) {

	           $revenueData = AnnualRevenue::create(['annual_revenue' => $csvRevenue]);

	        	$revenueId = $revenueData->id;

	        }else{

	        	$revenueId = $revenue[0]->id;
	        }

	        // insert data into company_divisions table
	    	 $comDiv = new CompanyDivision;

	        $compData = CompanyDivision::where('company_division', '=', $csvcomDiv)
	        		 	->where('division_number', '=', $csvDivNum)->get('id');

	        if ($compData->isEmpty()) {

		         $comDivs = CompanyDivision::create(['company_division'=> $csvcomDiv, 'division_number'=> $csvDivNum]);

	        	$comDivID = $comDivs->id;

	        }else{

	        	$comDivID = $compData[0]->id;
	        }

	        // insert data into lead_metas table

	    	 $ldMeta = new LeadMeta;

	        $meta = LeadMeta::where('lead_id', '=', $id)
				        ->where('fiscal_year_id', '=', $fiscalyearId)
				        ->where('company_division_id', '=', $comDivID)
				       	->where('annual_revenue_id', '=', $revenueId)->get('id');

	        if ($meta->isEmpty()) {

	          $newMeta = LeadMeta::create(['lead_id'=> $id,'fiscal_year_id'=> $fiscalyearId, 'company_division_id'=> $comDivID, 'annual_revenue_id'=> $revenueId]);
	        }

	    }
	    echo "Data Inserted Successfully...!";
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
	 	}


	 	return $name;
	}


  public function addCountry()
  {
    $file = base_path('resources/csv/countries.csv');

    $countries = $this->csvToArray($file);
    // print_r($countries);die;
    $count = 0;
    $countInsert = 0;
    $countUpdate = 0;
    foreach ($countries as $key => $value) {

        $alpha2 = $value['alpha-2'];
        $alpha3 = $value['alpha-3'];
        $country = $value['name'];

        $insert = Country::firstOrCreate(['name' => $country,
                        'alpha_2' => $alpha2,
                      'alpha_3' => $alpha3 ]);

        if ($insert->wasRecentlyCreated) {
            $countInsert++;
        }else{
            $countUpdate++;
        }
        $count++;
    }
    echo "Countries Inserted Successfully <br/>";
    echo "Total Rows:".$count."<br/>";
    echo "Inserted Rows:".$countInsert."<br/>";
    echo "Updated Rows:".$countUpdate."<br/>";
  }


  public function addStates()
  {
   $file = base_path('resources/csv/usa_states.csv');

   $states = $this->csvToArray($file);
   // print_r($countries);die;
   $count = 0;
   $countInsert = 0;
   $countUpdate = 0;
   foreach ($states as $key => $value) {

       $state = $value['State'];
       $abbr = $value['Abbreviation'];

       // only for USA
       $insert = State::firstOrCreate(['country_id' => 236,
           'name' => $state,
            'abbr' => $abbr ]);

       if ($insert->wasRecentlyCreated) {
           $countInsert++;
       }else{
           $countUpdate++;
       }
       $count++;
   }
   echo "States Inserted Successfully <br/>";
   echo "Total Rows:".$count."<br/>";
   echo "Inserted Rows:".$countInsert."<br/>";
   echo "Updated Rows:".$countUpdate."<br/>";
  }



  public function addCities(){
    $file = base_path('resources/csv/cities.csv');
    $cities = $this->csvToArray($file);
    //echo "<pre>" . var_export($cities,true) . "</pre>";

  //  echo "<pre>" . var_export($cities,true) . "</pre>";
    foreach ($cities as $key => $v) {

        $state = State::where('abbr', $v['State'])->first();

       //echo $v['City'] . "</br>";
       echo "<pre>" . var_export($state->name,true) . "</pre>";

    }
    die();

 dd($cities);


  }

}

<?php
namespace App\Exports;

use App\Lead;
Use App\BusinessType;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromArray;


class LeadsExport implements FromArray, WithHeadings
{

		use Exportable;

		public function __construct(array $ids)
		{
			$this->ids = $ids;
		}

		public function headings(): array
    {
        return [
            'First Name',
            'Last Name',
            'Email',
						'Phone',
						'Primary NAICS',
						'Legal Business Name',
						'DBA',
						'Physical Address Line 1',
						'Physical Address Line 2',
						'Physical City',
						'Physical Zip Code',
						'Physical State',
						'Physical Country',
						'Business Start Date',
						'Fiscal Year End Close Date',
						'Corporate URL',
						'State Of Incorporation',
						'Country Of Incorporation',
						'Mailing Address Line 1',
						'Mailing Address Line 2',
						'Mailing City',
						'Mailing Zip Code',
						'Mailing State',
						'Mailing Country',
        ];
    }

		public function array(): array

		    {

				//	return dd($this->ids);

					$leads = Lead::with(['naics_codes','psc_codes','business_types','contacts','countries','states','cities','zips','mail_countries','mail_states','mail_cities','mailZips','physicalStreets','mailingStreets','stateOfIncorpo','countryOfIncorpo'])
										->whereIn('id', $this->ids)->get();

					$contacts = [];
					// return dd($leads->toArray());
					$naics = $p_address1 = $p_address2 = $m_address1 = $m_address2 = $country = $state =$city = $zip = $mcountry = $mcity = $mstate = $mzip = $stateOfInco = $countryOfInco = "";
					foreach ( $leads as $id => $lead ){

						// naics
						if ($lead->naics_codes->count()>0) {

							$naics = $lead->naics_codes->toArray()[0]['code'];

						}

						//physical street
						if ($lead->physicalStreets->count()>0) {

							$physical_address = $lead->physicalStreets->toArray();

							foreach ($physical_address as $key => $value) {
									$p_address1 = $value['address'];

									if ($key == 1) {
										$p_address2 = $value['address'];
									}
							}

						}

						//Mailing street
						if ($lead->mailingStreets->count()>0) {

							$mailing_address = $lead->mailingStreets->toArray();

							foreach ($mailing_address as $key => $value) {
									$m_address1 = $value['address'];

									if ($key == 1) {
										$m_address2 = $value['address'];
									}
							}

						}

						//country of incorporations
						if ($lead->countryOfIncorpo->count()>0) {

							$countryOfInco = $lead->countryOfIncorpo->toArray()[0]['alpha_3'];

						}

						//state of incorporations
						if ($lead->stateOfIncorpo->count()>0) {

							$stateOfInco = $lead->stateOfIncorpo->toArray()[0]['name'];

						}

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

						foreach( $lead->contacts as $contact ){
							$contacts[] = array(
									$contact->first_name,
									$contact->last_name,
									$contact->email_address,
									$contact->contact_phone,
									$naics,
									$lead->legal_business_name,
									$lead->dba_name,
									$p_address1,
									$p_address2,
									$city,
									$zip,
									$state,
									$country,
									$lead->business_start_date,
									$lead->fiscal_year,
									$lead->corporate_url,
									$stateOfInco,
									$countryOfInco,
									$m_address1,
									$m_address2,
									$mcity,
									$mzip,
									$mstate,
									$mcountry,

							);
						}
					//end foreach

}

					// return dd($contacts);
		        return [
		            $contacts
		        ];

		}
		// end function


}

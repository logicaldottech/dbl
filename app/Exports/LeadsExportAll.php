<?php
namespace App\Exports;

use App\Lead;
Use App\BusinessType;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromArray;


class LeadsExportAll implements FromArray, WithHeadings
{

		use Exportable;

		public function __construct(Object $leads)
		{
			$this->leads = $leads;
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
						'Business Start Date',
						'Corporate URL',


        ];
    }

		public function array(): array

		    {

				//	return dd($this->ids);

					$leads = $this->leads;

					//return dd($leads);
					$contacts = [];
				//	return dd($leads);

					foreach ( $leads as $id => $lead ){

						foreach( $lead->contacts as $contact ){
							$contacts[] = array(
									$contact->first_name,
									$contact->last_name,
									$contact->email_address,
									$contact->contact_phone,
									$lead->naics_codes->toArray()[0]['code'],
									$lead->legal_business_name,
									$lead->dba_name,
									$lead->business_start_date,
									$lead->corporate_url,

							);
						}


					}

					//return dd($contacts);


				//	return dd($contacts);
		        return [
		            $contacts
		        ];
		    }







}

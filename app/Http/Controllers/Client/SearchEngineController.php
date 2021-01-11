<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use Illuminate\Support\Facades\DB;

class SearchEngineController extends Controller
{
    private $partners;
    private $certificates;
    private $user;

    /**
     * Initializes the search engine view.
     *
     * @return view
     */
    public function show()
    {
        return view('client.search_engine_view', [
            'user' => $this->fetchUser(),
            'partners' => $this->fetchPartners(),
            'certificates' => $this->fetchCertificates()
        ]);
    }

    /**
     * Filters the search result based on the incoming request.
     *
     * @return view
     */
    public function filter()
    {
        $filters = request('filter');
        $capitalDemand = request('capital');
        $filteredResult = [];

        foreach ($this->fetchPartners() as $arrayOfPartners => $individualPartner) {

            if($capitalDemand !== null){

                $isDemandMet = $this->checkAgainstCapitalFilter($individualPartner, $capitalDemand);

                if ($isDemandMet) {
                    $filteredResult[] = $individualPartner;
                }
            }
            // Further filters should be done on the filteredList, not on fetchPartners.
        }

        return view('client.search_engine_view', [
            'user' => $this->fetchUser(),
            'partners' => empty($filteredResult) ? $this->fetchPartners() : $filteredResult,
            'certificates' => $this->fetchCertificates()
        ]);
    }

    private function checkAgainstCapitalFilter(array $individualPartner, $capitalDemand)
    {
        foreach ($individualPartner as $attribute => $value) {
            if ($capitalDemand > 1 && $attribute === 'capital') {
                if ($value >= $capitalDemand) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Returns the authenticated user.
     *
     * @return array
     */
    public function fetchUser()
    {
        if (!$this->user) {
            $this->user =  auth()->user();
        }

        return $this->user;
    }

    /**
     * Return all partners from the DB with associated tables connected.
     *
     * @return array
     */
    public function fetchPartners()
    {
        if (!$this->partners) {
            $this->partners = [];

            foreach (DB::select(DB::raw('SELECT partners.*, zipcodes.zipcode, zipcodes.city, group_concat(certifications.certification_name) as filters FROM partners
            LEFT JOIN certification_partner ON partners.id = certification_partner.partner_id
            LEFT JOIN certifications ON certification_partner.certification_id = certifications.id
            LEFT JOIN zipcodes ON partners.zipcode_id = zipcodes.id
            GROUP BY partners.id')) as $partner) {
                $this->partners[] = [
                    'cvr' => $partner->cvr,
                    'company_name' => $partner->company_name,
                    'company_address' => $partner->company_address,
                    'zipcode' => $partner->zipcode,
                    'city' => $partner->city,
                    'phone' => $partner->phone,
                    'start_date' => $partner->start_date,
                    'capital' => $partner->capital,
                    'filters' => explode(',', $partner->filters)
                ];
            }
        }

        return $this->partners;
    }

    /**
     * Returns all certificates.
     *
     * @return array
     */
    public function fetchCertificates()
    {
        if (!$this->certificates) {
            $this->certificates = Certification::all();
        }

        return $this->certificates;
    }
}

<?php

namespace App\Http\Livewire\Client;

use App\Models\Certification;
use Livewire\Component;
use App\Models\Partner;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SearchEngine extends Component
{
    public $user;
    public $partners;
    public $filteredList = [];
    public $certificates = [];

    public $filterStartDate;
    public $filterNumberOfEmployees;
    public $filterCapital;
    public $filterISOCertifications = [];

    public function mount()
    {
        $this->user = auth()->user();
        $this->partners = Partner::all();
        $this->filteredList = null;
        $this->certificates = Certification::all();
    }

    public function filterList(Request $request)
    {
        $this->filteredList = []; //null

        $count = 0; // 0

         $payload = json_decode($request->getContent(), true);

         dd($payload['filterISOCertifications']);
        //TEST START

        $query = DB::table('partners')->get();

        if (isset($this->filterISOCertifications)) {

            //$this->filteredList = [];

            foreach ($this->filterISOCertifications as $certificate) {

                // ISO 9001
                // ISO 9002
                /*$partners = Partner::where(function ($query) {
                    $query->select('*')
                        ->from('partners');
                });*/

                /*$query = DB::table('partners')->where(function ($q) {
                });*/

                $query->where('certifications'.'='.$certificate);

                /*foreach ($query->whereHas('certifications', function ($q) use ($certificate) {
                    $q->where('certification_name', '=', $certificate);
                })->get() as $partner) {
                    $this->filteredList[] = $partner;
                }*/
            }

            dd($query);


            //$query->where(Input::get('filter'), '=', Input::get('value'));
        }

        //dd($result);



        //TEST SLUT

        if (isset($this->filterISOCertifications)) { //Kør kun hvis sat.
            $this->filteredList = [];
            foreach ($this->filterISOCertifications as $certificate) {
                if ($count === 0) {
                    foreach (Partner::withCertificate($certificate) as $partner) {
                        $this->filteredList[] = $partner;                       // X antal partnere.
                    }
                } else {

                    $temporaryArray = [];                                       // nyt temporary array

                    foreach (Partner::withCertificate($certificate) as $partner) {      // Tilføj x partnere til temp array
                        $temporaryArray[] = $partner;
                    }
                    if (isset($temporaryArray)) {
                        foreach ($this->filteredList as $potentialMatch) {          // For hvert resultat i første omgang, find nyt match eller slet.
                            if (!Arr::exists($temporaryArray, $potentialMatch)) {
                                $placement = array_search($potentialMatch, $temporaryArray);
                                unset($this->filteredList[$placement]);
                            }
                        }
                    }
                }
                $count++;
            }
        }



        // Første gang matcher (1,2,3,4,5,6,7,8,9) -> filteredList
        // Anden gang matcher (2,4,6,8) ->filteredList
        // Tredje gang matcher (2,6)

        // Array efter første omgang: (1,2,3,4,5,6,7,8,9)
        // I anden omgang søger vi efter og sletter alle instanser som vi ikke finder.
        // Resultat: (2,4,6,8);
        // I tredje omgang søger vi efter og sletter alle instanser som vi ikke finder.
        // Resultat: (2,6)
    }

    public function render()
    {

        return view('livewire.client.search-engine');
    }
}

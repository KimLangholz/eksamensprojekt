<?php

namespace Tests\Feature;

use Tests\TestCase;

class VendorTest extends TestCase
{

     //TODO replace testable CVR number with Partforms CVR number when received.

    /** @test */
    public function does_CVR_api_work()
    {
        $response = \Cvrapi\Cvrapi::get('20165715', 'dk', 'Description of my project');

        $this->assertEquals('Nordborgvej 81', $response->address);
        $this->assertEquals('DANFOSS A/S', $response->name);
        $this->assertEquals('20165715', $response->vat);
    }
}

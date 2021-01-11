<?php

namespace Tests;

use Illuminate\Support\Facades\Artisan;
use Laravel\BrowserKitTesting\TestCase as BaseTestCase;

abstract class BrowserTestCase extends BaseTestCase
{
    use CreatesApplication;

    public $baseUrl = 'http://localhost:8001';

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate:fresh');
        $this->artisan('db:seed');

        // Swap out the Mix manifest implementation, so we don't need
        // to run the npm commands to generate a manifest file for
        // the assets in order to run tests that return views.

    }
}

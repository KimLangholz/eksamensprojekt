<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->integer('cvr');
            $table->string('company_name');
            $table->string('company_address');
            $table->integer('zipcode_id');
            $table->integer('country_id');
            $table->string('phone')->nullable();
            $table->string('start_date')->nullable();
            $table->string('employee_range_from_cvr')->nullable();
            $table->integer('number_of_employees')->nullable();
            $table->string('industry_code')->nullable();
            $table->string('company_code')->nullable();
            $table->string('capital')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('partner');
    }
}

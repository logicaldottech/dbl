<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndustryCodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('industry_code', function (Blueprint $table) {
          $table->increments('id');
          $table->mediumInteger('naics_code_id')->unsigned();
          $table->integer('naics_industry_id')->unsigned();
          $table->timestamps();

          $table->foreign('naics_code_id')
            ->references('id')->on('naics_codes')
            ->onDelete('cascade');

          $table->foreign('naics_industry_id')
            ->references('id')->on('naics_industries')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('industry_code');
    }
}

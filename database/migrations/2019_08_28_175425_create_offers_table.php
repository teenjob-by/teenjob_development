<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->integer('city_id')->unsigned();
            $table->foreign('city_id')->references('id')->on('cities');
            $table->integer('speciality');
            $table->integer('age');
            $table->integer('type')->nullable();
            $table->longText('description')->nullable();
            $table->string('contact');
            $table->string('phone');
            $table->string('email');
            $table->string('alt_phone')->nullable();
            $table->unsignedInteger('status')->default(0);
            $table->unsignedInteger('offer_type')->default(0);
            $table->dateTime('published_at')->nullable();
            $table->integer('organisation_id')->unsigned();
            $table->foreign('organisation_id')->references('id')->on('organisations')->onDelete('cascade');
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
        Schema::dropIfExists('internships');
    }
}

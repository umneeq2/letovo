<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePupilsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pupils', function (Blueprint $table) {
            $table->id();
            $table->string('fullname', 100);
            $table->string('mobile_phone', 20)->unique();
            $table->string('email', 100)->unique();
            $table->string('address', 200);
            // range from -90 to 90 for latitude and -180 to 180 for longitude
            $table->float('geo_lon', 11, 8)->nullable(); // https://dadata.ru/api/clean/address/#response
            $table->float('geo_lat', 11, 9)->nullable();
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
        Schema::dropIfExists('pupils');
    }
}

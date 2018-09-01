<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrentRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('current_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned(); // this is shared user id
            $table->string('share_with', 1); // M=male; F=Female; B = Both(Male & Female)
            $table->double('lat');
            $table->double('lng');
            $table->double('des_lat');
            $table->double('des_lng');
            $table->string('country_code', 3);
            $table->string('address', 191)->nullable();            
            $table->tinyInteger('status')->default(1); // 1 = request is alive; 2 = request cancle; 3 = request time out; 4 = share success;
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
        Schema::dropIfExists('current_requests');
    }
}

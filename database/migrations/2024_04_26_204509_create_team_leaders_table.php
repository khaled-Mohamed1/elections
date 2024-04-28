<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_leaders', function (Blueprint $table) {
            $table->id();
            $table->string('tl_name')->nullable();
            // $table->string('tl_team_name')->nullable();
            $table->string('tl_phone_NO1', 11)->nullable();
            $table->string('tl_phone_NO2', 11)->nullable();
            $table->string('address')->nullable();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');;
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
        Schema::dropIfExists('team_leaders');
    }
};

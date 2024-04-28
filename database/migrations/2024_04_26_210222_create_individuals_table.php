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
        Schema::create('individuals', function (Blueprint $table) {
            $table->id();
            $table->string('i_name')->nullable();
            $table->string('i_NO')->nullable()->unique();
            $table->string('i_phone_NO', 11)->nullable();
            $table->string('address')->nullable();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            // Add foreign key for Electoral Center
            $table->bigInteger('electoral_id')->unsigned()->nullable();
            $table->foreign('electoral_id')->references('id')->on('electoral_centers')->nullOnDelete();

            // Add foreign key for TeamLeader
            $table->bigInteger('team_leader_id')->unsigned()->nullable();
            $table->foreign('team_leader_id')->references('id')->on('team_leaders')->nullOnDelete();

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
        Schema::dropIfExists('individuals');
    }
};

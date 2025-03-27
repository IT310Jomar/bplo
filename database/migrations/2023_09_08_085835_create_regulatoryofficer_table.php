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
        Schema::create('regulatoryofficer', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('middlename')->nullable();
            $table->string('contact');
            // $table->string('email');
            // $table->string('password');
            $table->enum('status',['Active','Disable'])->default('Active');
            $table->string('image')->nullable();
            $table->string('position');
            $table->string('address');
            $table->string('age')->nullable();
            $table->enum('gender',['Male','Female']);
            // $table->bigInteger('department_id')->unsigned();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('user_id') -> references('id') ->on('users');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('regulatoryofficer');
    }
};

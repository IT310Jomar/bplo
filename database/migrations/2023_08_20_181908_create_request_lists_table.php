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
        Schema::create('request_lists', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('client_id')->unsigned();
            $table->bigInteger('permit_id')->unsigned();
            $table->bigInteger('category_id')->unsigned();
            // $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('request_status_id')->unsigned();
            $table->enum('bfp_status',['Pending','Approved','Reject'])->default('Pending');
            // $table->bigInteger('cleanro_id')->unsigned();
            // $table->bigInteger('health_id')->unsigned();
            $table->enum('buco_status',['Pending','Approved','Reject'])->default('Pending');
            $table->enum('health_status',['Pending','Approved','Reject'])->default('Pending');
            $table->enum('cleanro_status',['Pending','Approved','Reject'])->default('Pending');
            $table->enum('generated_status',['Yes','No'])->default('No');
            $table->date('requirements')->nullable();
            $table->timestamps();

            $table->foreign('client_id') -> references('id') ->on('clients');
            $table->foreign('permit_id') -> references('id') ->on('types_of_permits');
            $table->foreign('category_id') -> references('id') ->on('permit_categories');
            // $table->foreign('department_id') -> references('id') ->on('departments');
            $table->foreign('request_status_id') -> references('id') ->on('request_status');
            // $table->foreign('user_id') -> references('id') ->on('users');

            // $table->foreign('bfp_id') -> references('id') ->on('bfp_status');
            // $table->foreign('cleanro_id') -> references('id') ->on('cleanro_status');
            // $table->foreign('health_id') -> references('id') ->on('health_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('request_lists');
    }
};

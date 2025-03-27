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
        Schema::create('generated_history_list', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('request_list_id');
            $table->timestamps();


            $table->foreign('request_list_id') -> references('id') ->on('request_lists');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('generated_history_list');
    }
};

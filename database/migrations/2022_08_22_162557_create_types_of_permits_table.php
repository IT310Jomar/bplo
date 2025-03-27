<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('types_of_permits', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->bigInteger('department_id')->unsigned()->nullable();
            $table->timestamps();
        });
        $data=array('Isuance Of Permit & Liceses','Isuance Of Occupationsl Permit','Certificate Of No Record');
        foreach($data as $val){
            DB::table('types_of_permits') -> insert(
             array('name'=> $val)
            );
 
         }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('types_of_permits');
    }
};

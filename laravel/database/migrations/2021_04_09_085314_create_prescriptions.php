<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrescriptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code');
            $table->tinyInteger('customer_id')->index()->nullable();
            $table->tinyInteger('user_id')->index()->nullable();
            $table->tinyInteger('symptom_id');
            $table->tinyInteger('medicine_id');
            $table->
            $table->tinyInteger('status')->default(1)->comment('1-active; 0-deleted; 2-inactive')->nullable();
            
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
        Schema::dropIfExists('prescriptions');
    }
}

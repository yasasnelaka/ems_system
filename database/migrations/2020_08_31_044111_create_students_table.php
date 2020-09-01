<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->bigIncrements('id')->unique();
            $table->bigInteger('st_id')->primary();
            $table->string('course_interested');
            $table->string('surname');
            $table->integer('nic');
            $table->string('email');
            $table->integer('tel');
            $table->integer('mobile_number');
            $table->string('address');
            $table->string('city');
            $table->date('dob');
            $table->string('gender');
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
        Schema::dropIfExists('students');
    }
}

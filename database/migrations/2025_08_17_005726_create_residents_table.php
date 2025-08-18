<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('residents', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('age')->nullable();
            $table->unsignedBigInteger('gender_type_id')->nullable();
            $table->foreign('gender_type_id')->references('id')->on('genders');
            $table->string('address')->nullable();
            $table->string('birth_date')->nullable();
            $table->unsignedBigInteger('civil_status_type_id')->nullable();
            $table->foreign('civil_status_type_id')->references('id')->on('civil_statuses');
            $table->string('occupation')->nullable();
            $table->unsignedBigInteger('voters_status_type_id')->nullable();
            $table->foreign('voters_status_type_id')->references('id')->on('voters_statuses');
            $table->string('email_address')->nullable();
            $table->unsignedBigInteger('citezenship_type_id')->nullable();
            $table->foreign('citezenship_type_id')->references('id')->on('citezenships');
            $table->string('household_no')->nullable();
            $table->string('precinct_no')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('residents');
    }
};
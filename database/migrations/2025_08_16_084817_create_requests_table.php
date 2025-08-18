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
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('purposes')->nullable();
            $table->string('pick_up_date')->nullable();
            $table->string('reference_no')->nullable();
            $table->string('or_no')->nullable();
            $table->string('tracking_code')->nullable();
            $table->unsignedBigInteger('request_type_id')->nullable();
            $table->foreign('request_type_id')
                ->references('id')
                ->on('services');
            $table->unsignedBigInteger('payment_type_id')->nullable();
            $table->foreign('payment_type_id')
                ->references('id')
                ->on('payment_types');
            $table->unsignedBigInteger('status_id')->nullable();
            $table->foreign('status_id')
                ->references('id')
                ->on('statuses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};

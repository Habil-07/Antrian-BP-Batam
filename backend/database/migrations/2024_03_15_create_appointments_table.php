<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('main_service');
            $table->string('sub_service');
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->string('customer_name');
            $table->string('customer_nik', 16);
            $table->string('customer_phone');
            $table->string('queue_prefix');
            $table->string('queue_number');
            $table->enum('status', ['waiting', 'called', 'completed', 'cancelled'])->default('waiting');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
}; 
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
        Schema::create('tr_services', function (Blueprint $table) {
            $table->id();

            // Relasi ke ms_services
            $table->foreignId('service_id')->constrained('ms_services')->onDelete('cascade');

            // Relasi ke msuser. Ini harus user dengan Role ID 2 (Customer)
            $table->foreignId('user_id')->constrained('msuser')->onDelete('cascade');

            // Nomor Antrian (Contoh: A-001, B-012)
            $table->string('queue_number');

            // Status antrian
            $table->enum('status', ['waiting', 'processing', 'completed', 'cancelled'])->default('waiting');

            // Tanggal antrian (Penting agar antrian bisa di-reset tiap hari)
            $table->date('queue_date');

            // Estimasi waktu (Opsional, buat fitur advanced nanti)
            $table->time('estimated_time')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tr_services');
    }
};

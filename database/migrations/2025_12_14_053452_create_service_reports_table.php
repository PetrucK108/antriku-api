<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('service_reports', function (Blueprint $table) {
            $table->id();
            $table->date('report_date');
            $table->unsignedBigInteger('created_by'); // user yang generate report
            $table->text('file_path'); // path PDF yang disimpan
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('msuser')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_reports');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();

            // Data pribadi
            $table->string('full_name');
            $table->string('phone', 30);
            $table->string('birth_place', 100);
            $table->date('birth_date');
            $table->string('nik', 30)->unique();
            $table->text('address');

            // Data penempatan
            $table->string('placement_company');
            $table->string('department');

            // Data bank
            $table->string('bank_name', 100);
            $table->string('bank_account_number', 50);
            $table->string('bank_account_holder', 150);

            // Data kontrak
            $table->date('contract_start');
            $table->date('contract_end');

            // Status karyawan
            $table->string('status', 20)->default('active');

            // Dokumen privat
            $table->string('face_photo_path')->nullable();
            $table->string('ktp_file_path')->nullable();
            $table->string('kk_file_path')->nullable();

            $table->timestamps();

            $table->index(['status', 'contract_end']);
            $table->index('placement_company');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
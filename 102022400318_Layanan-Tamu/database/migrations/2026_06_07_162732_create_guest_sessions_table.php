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
        Schema::create('guest_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('room_number', 10);      // Nomor kamar tamu
            $table->string('guest_name', 100);     // Nama lengkap tamu
            $table->string('session_token', 64)->unique(); // Token unik untuk akses API
            $table->timestamp('check_in_at')->nullable();  // Waktu check-in
            $table->timestamp('check_out_at')->nullable(); // Waktu check-out
            $table->enum('status', ['active', 'expired'])->default('active'); // Status sesi
            $table->timestamps();                   // Otomatis bikin created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guest_sessions');
    }
};

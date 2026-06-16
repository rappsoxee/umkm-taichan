<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('no_invoice')->unique();
            $table->date('tanggal_transaksi');
            $table->foreignId('customer_id')->nullable()->constrained('customers')->onDelete('set null');
            $table->unsignedBigInteger('total_harga');
            $table->enum('status_pembayaran', ['lunas', 'belum_lunas'])->default('lunas');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('customer_id')->nullable()->after('no_meja')->constrained('customers')->onDelete('set null');
            $table->unsignedBigInteger('diskon')->default(0)->after('total_harga');
            $table->unsignedInteger('poin_digunakan')->default(0)->after('diskon');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['customer_id']);
            $table->dropColumn(['customer_id', 'diskon', 'poin_digunakan']);
        });
    }
};
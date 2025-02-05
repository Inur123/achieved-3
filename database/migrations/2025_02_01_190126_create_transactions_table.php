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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('order_id')->unique();  // Tambahkan order_id unik untuk Midtrans
            $table->string('name');
            $table->string('email');
            $table->string('phone_number');
            $table->enum('status', ['pending', 'paid', 'approved', 'failed'])->default('pending');
            $table->string('snap_token')->nullable();  // Tambahkan status 'failed'
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};

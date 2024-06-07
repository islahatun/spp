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
        Schema::create('trans_tagihan_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trans_tagihan_id');
            $table->string('order_id');
            $table->date('date');
            $table->double('payment');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trans_tagihan_details');
    }
};

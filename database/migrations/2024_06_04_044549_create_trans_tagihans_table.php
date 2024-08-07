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
        Schema::create('trans_tagihans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('kelas',2);
            $table->date('from_date');
            $table->date('to_date');
            $table->double('billing');
            $table->double('total_billing');
            $table->string('status',1)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trans_tagihans');
    }
};

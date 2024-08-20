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
        Schema::create('tujuan_depos', function (Blueprint $table) {
            $table->id();
            $table->string('noacc_depo')->unique();
            $table->string('type_tran')->enum('cash', 'tabungan', 'transfer');
            $table->string('norek_tujuan')->nullable();
            $table->string('an_tujuan')->nullable();
            $table->string('nama_bank')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tujuan_depos');
    }
};

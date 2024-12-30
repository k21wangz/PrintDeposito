<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('it_deposito_tanpa_pajak', function (Blueprint $table) {
            $table->id();
            $table->string('noacc', 20);
            $table->string('keterangan')->nullable();
            $table->string('created_by')->nullable();
            $table->timestamps();
            
            $table->unique('noacc');
        });
    }

    public function down()
    {
        Schema::dropIfExists('it_deposito_tanpa_pajak');
    }
}; 
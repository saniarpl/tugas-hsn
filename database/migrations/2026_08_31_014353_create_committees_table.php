<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('committees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('position'); // Jabatan (Ketua, Sekretaris, dll)
            $table->string('organization'); // nu, ipnu, ippnu, fatayat, muslimat, banser
            $table->string('photo')->nullable(); // Foto pengurus
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('committees');
    }
};
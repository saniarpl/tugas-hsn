<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Skema lama memakai kolom "photo", sedangkan database aplikasi dan
     * seluruh tampilan admin memakai "image". Samakan agar instalasi baru
     * dan database yang sudah berjalan memiliki struktur yang sama.
     */
    public function up(): void
    {
        if (Schema::hasColumn('committees', 'photo') && ! Schema::hasColumn('committees', 'image')) {
            Schema::table('committees', function (Blueprint $table) {
                $table->renameColumn('photo', 'image');
            });
        }

        if (! Schema::hasColumn('committees', 'image')) {
            Schema::table('committees', function (Blueprint $table) {
                $table->string('image')->nullable()->after('organization');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('committees', 'image') && ! Schema::hasColumn('committees', 'photo')) {
            Schema::table('committees', function (Blueprint $table) {
                $table->renameColumn('image', 'photo');
            });
        }
    }
};

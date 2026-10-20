<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Kolom yang di skema NOT NULL tetapi di form admin bersifat opsional
     * (lokasi kegiatan; NIK, alamat, dan HP warga) dibuat nullable agar
     * pengiriman form valid tidak lagi 500. Tanpa doctrine/dbal sehingga
     * memakai SQL per driver.
     */
    public function up(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE `activities` MODIFY `location` VARCHAR(255) NULL');
            DB::statement('ALTER TABLE `members` MODIFY `nik` VARCHAR(255) NULL');
            DB::statement('ALTER TABLE `members` MODIFY `address` TEXT NULL');
            DB::statement('ALTER TABLE `members` MODIFY `phone` VARCHAR(255) NULL');
        } elseif ($driver === 'sqlite') {
            $this->rebuildSqlite('activities', implode(', ', [
                '`id` INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL',
                '`title` VARCHAR(255) NOT NULL',
                '`date` DATE NOT NULL',
                '`location` VARCHAR(255) NULL',
                '`description` TEXT NOT NULL',
                '`image` VARCHAR(255) NULL',
                '`created_at` TIMESTAMP NULL',
                '`updated_at` TIMESTAMP NULL',
            ]));
            $this->rebuildSqlite('members', implode(', ', [
                '`id` INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL',
                '`name` VARCHAR(255) NOT NULL',
                '`nik` VARCHAR(255) NULL UNIQUE',
                '`address` TEXT NULL',
                '`phone` VARCHAR(255) NULL',
                '`photo` VARCHAR(255) NULL',
                '`created_at` TIMESTAMP NULL',
                '`updated_at` TIMESTAMP NULL',
            ]));
        } elseif ($driver === 'pgsql') {
            DB::statement('ALTER TABLE "activities" ALTER COLUMN "location" DROP NOT NULL');
            DB::statement('ALTER TABLE "members" ALTER COLUMN "nik" DROP NOT NULL');
            DB::statement('ALTER TABLE "members" ALTER COLUMN "address" DROP NOT NULL');
            DB::statement('ALTER TABLE "members" ALTER COLUMN "phone" DROP NOT NULL');
        }
    }

    public function down(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE `activities` MODIFY `location` VARCHAR(255) NOT NULL');
            DB::statement('ALTER TABLE `members` MODIFY `nik` VARCHAR(255) NOT NULL');
            DB::statement('ALTER TABLE `members` MODIFY `address` TEXT NOT NULL');
            DB::statement('ALTER TABLE `members` MODIFY `phone` VARCHAR(255) NOT NULL');
        } elseif ($driver === 'sqlite') {
            $this->rebuildSqlite('activities', implode(', ', [
                '`id` INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL',
                '`title` VARCHAR(255) NOT NULL',
                '`date` DATE NOT NULL',
                '`location` VARCHAR(255) NOT NULL',
                '`description` TEXT NOT NULL',
                '`image` VARCHAR(255) NULL',
                '`created_at` TIMESTAMP NULL',
                '`updated_at` TIMESTAMP NULL',
            ]));
            $this->rebuildSqlite('members', implode(', ', [
                '`id` INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL',
                '`name` VARCHAR(255) NOT NULL',
                '`nik` VARCHAR(255) NOT NULL UNIQUE',
                '`address` TEXT NOT NULL',
                '`phone` VARCHAR(255) NOT NULL',
                '`photo` VARCHAR(255) NULL',
                '`created_at` TIMESTAMP NULL',
                '`updated_at` TIMESTAMP NULL',
            ]));
        } elseif ($driver === 'pgsql') {
            DB::statement('ALTER TABLE "activities" ALTER COLUMN "location" SET NOT NULL');
            DB::statement('ALTER TABLE "members" ALTER COLUMN "nik" SET NOT NULL');
            DB::statement('ALTER TABLE "members" ALTER COLUMN "address" SET NOT NULL');
            DB::statement('ALTER TABLE "members" ALTER COLUMN "phone" SET NOT NULL');
        }
    }

    private function rebuildSqlite(string $table, string $columns): void
    {
        // Ambil nama kolom polos dari definisi untuk INSERT ... SELECT
        preg_match_all('/`([a-z_]+)`\s/i', $columns, $m);
        $cols = '`' . implode('`, `', $m[1]) . '`';
        DB::statement("CREATE TABLE {$table}_new ({$columns})");
        DB::statement("INSERT INTO {$table}_new ({$cols}) SELECT {$cols} FROM {$table}");
        DB::statement("DROP TABLE {$table}");
        DB::statement("ALTER TABLE {$table}_new RENAME TO {$table}");
    }
};

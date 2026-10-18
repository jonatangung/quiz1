<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('user')) {
            Schema::create('user', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('username')->unique();
                $table->string('password');
                $table->string('email')->unique();
                $table->string('level', 20)->nullable();
                $table->timestamps();
            });
        } elseif (!Schema::hasColumn('user', 'email')) {
            Schema::table('user', function (Blueprint $table) {
                $table->string('email')->nullable()->unique();
            });
        }

        if (!Schema::hasTable('karyawan')) {
            Schema::create('karyawan', function (Blueprint $table) {
                $table->bigIncrements('id_kry');
                $table->unsignedBigInteger('id_user');
                $table->string('nama_kry');
                $table->string('alamat_kry');
                $table->string('jk_kry', 10);
                $table->timestamps();
            });
        } elseif (DB::getDriverName() === 'mysql') {
            $column = DB::selectOne("SHOW COLUMNS FROM `karyawan` LIKE 'id_kry'");

            if ($column && !str_contains($column->Extra, 'auto_increment')) {
                DB::statement('ALTER TABLE `karyawan` MODIFY `id_kry` INT NOT NULL AUTO_INCREMENT');
            }
        }
    }

    public function down(): void
    {
        // Existing user and karyawan tables may contain application data.
    }
};

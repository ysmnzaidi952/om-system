<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // 1. Rename ic → id_number
            $table->renameColumn('ic', 'id_number');
        });

        Schema::table('users', function (Blueprint $table) {
            // 2. Tukar dari NOT NULL ke nullable (passport boleh lain format)
            $table->string('id_number', 30)->nullable()->change();

            // 3. Tambah id_type column (lepas id_number)
            $table->enum('id_type', ['ic', 'passport'])->default('ic')->after('id_number');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('id_type');
            $table->renameColumn('id_number', 'ic');
        });
    }
};

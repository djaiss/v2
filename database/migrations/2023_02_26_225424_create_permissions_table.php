<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('action');
            $table->string('translation_key');
            $table->timestamps();
        });

        Schema::create('permission_role', function (Blueprint $table) {
            $table->string('permission_id');
            $table->string('role_id');
        });

        DB::table('permissions')->insert([
            'action' => 'create',
            'translation_key' => 'permissions.create',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};

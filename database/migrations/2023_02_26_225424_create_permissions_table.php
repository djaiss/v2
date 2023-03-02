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
            $table->unsignedBigInteger('company_id');
            $table->string('permission_id');
            $table->string('role_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });

        DB::table('permissions')->insert([
            'action' => 'settings.roles.create',
            'translation_key' => 'Create a new role',
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

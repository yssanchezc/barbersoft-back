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
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('name', 'names');
            $table->string('lastname');
            $table->date('date_birth');
            $table->string('phone');
            $table->text('address')->nullable();
            $table->unsignedBigInteger('role_id');
            $table->foreign('role_id')->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('user_names', 'name');
            $table->dropColumn('user_lastname');
            $table->dropColumn('date_birth');
            $table->dropColumn('phone');
            $table->dropColumn('address');
            $table->dropColumn('role_id');
        });
    }
};

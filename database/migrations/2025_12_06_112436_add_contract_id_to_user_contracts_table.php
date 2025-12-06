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
        Schema::table('user_contracts', function (Blueprint $table) {
            $table->unsignedBigInteger('contract_id')->nullable()->after('user_id');
            $table->foreign('contract_id')->references('id')->on('contracts')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_contracts', function (Blueprint $table) {
            //
        });
    }
};

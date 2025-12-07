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
            $table->unsignedBigInteger('hiring_project_id')->nullable()->after('is_hired');
            $table->date('hire_start_date')->nullable();
            $table->date('hire_end_date')->nullable();
            $table->foreign('hiring_project_id')
                  ->references('id')
                  ->on('hiring_projects')
                  ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};

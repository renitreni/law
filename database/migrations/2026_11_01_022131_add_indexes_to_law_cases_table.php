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
        Schema::table('law_cases', function (Blueprint $table) {
            $table->index('case_category');
            $table->index('case_status');
            $table->index('case_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('law_cases', function (Blueprint $table) {
            $table->dropIndex(['case_category']);
            $table->dropIndex(['case_status']);
            $table->dropIndex(['case_date']);
        });
    }
};

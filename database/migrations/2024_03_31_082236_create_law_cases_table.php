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
        Schema::create('law_cases', function (Blueprint $table) {
            $table->id();
            $table->string('case_title')->nullable()->default('N/A');
            $table->string('case_description')->nullable()->default('N/A');
            $table->string('case_category')->nullable()->default('N/A');
            $table->string('case_status')->nullable()->default('N/A');
            $table->string('case_attorney')->nullable()->default('N/A');
            $table->date('case_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('law_cases');
    }
};

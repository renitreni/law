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
        Schema::create('case_courts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('law_cases_id')->nullable();
            $table->foreign('law_cases_id')->references('id')->on('law_cases')->onDelete('set null');
            $table->date('court_date')->nullable();
            $table->string('court_address')->nullable();
            $table->string('court_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('case_courts');
    }
};

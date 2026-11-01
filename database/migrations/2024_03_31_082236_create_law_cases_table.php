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
            $table->string('case_plaintiff')->nullable();
            $table->string('case_defendant')->nullable();
            $table->text('case_description')->nullable();
            $table->string('case_category')->nullable();
            $table->string('case_status')->nullable();
            $table->string('case_attorney')->nullable();
            $table->date('case_date')->nullable();
            $table->softDeletes();
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

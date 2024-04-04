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
        Schema::create('case_clients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('law_cases_id')->nullable();
            $table->foreign('law_cases_id')->references('id')->on('law_cases')->onDelete('cascade');
            $table->string('name')->nullable()->default('N/A');
            $table->integer('age')->nullable();
            $table->date('birthday')->nullable();
            $table->string('contact')->nullable()->default('N/A');
            $table->string('company')->nullable()->default('N/A');
            $table->string('role')->nullable()->default('N/A');
            $table->string('attorney')->nullable()->default('N/A');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('case_clients');
    }
};

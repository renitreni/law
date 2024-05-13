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
            $table->string('client_name')->nullable()->default('N/A');
            $table->string('client_contact')->nullable()->default('N/A');
            $table->string('client_company')->nullable()->default('N/A');
            $table->string('client_email')->nullable()->default('N/A');
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

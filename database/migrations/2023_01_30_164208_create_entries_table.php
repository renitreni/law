<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entries', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id');
            $table->integer('matter_id');
            $table->integer('office_id');
            $table->date('entry_date');
            $table->float('duration');
            $table->text('narrative');
            $table->string('template_name')->nullable();
            $table->boolean('is_template');
            $table->boolean('is_draft');
            $table->boolean('is_billable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entries');
    }
};

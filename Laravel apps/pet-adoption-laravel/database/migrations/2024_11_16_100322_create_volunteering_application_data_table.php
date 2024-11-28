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
        Schema::create('volunteering_application_data', function (Blueprint $table) {
			        $table->id();
			        $table->string('name');
			        $table->string('email')->unique();
			        $table->string('phone');
			        $table->string('volunteering_area');
			        $table->text('message')->nullable();
			        $table->timestamp('submission_date')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('volunteering_application_data');
    }
};

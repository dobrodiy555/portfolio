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
        Schema::create('vet_booking_data', function (Blueprint $table) {
            $table->id();
	        $table->string('pet_name');
	        $table->string('owner_name');
		    $table->string('email')->unique();
		    $table->string('phone');
		    $table->string('location');
		    $table->date('preferred_date');
	        $table->time('preferred_time');
		    $table->text('reason')->nullable();
			$table->timestamp('submission_date')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vet_booking_data');
    }
};

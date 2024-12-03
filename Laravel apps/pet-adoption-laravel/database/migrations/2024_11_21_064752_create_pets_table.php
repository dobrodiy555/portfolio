<?php

use App\Models\User;
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
        Schema::create('pets', function (Blueprint $table) {
	        $table->id();
			$table->foreignIdFor(User::class);
	        $table->string('type'); // cat or dog
	        $table->string('name');
	        $table->unsignedTinyInteger('age');
	        $table->string('breed');
	        $table->string('gender');
	        $table->boolean('featured');
			$table->string('photo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};
